<?php
include 'encabezado.php';
require 'config.php';

/* ============================
   1. CAPTURA DE FILTROS
============================ */
$estado     = $_GET['estado']     ?? '';
$prioridad  = $_GET['prioridad']  ?? '';
$buscar     = $_GET['buscar']     ?? '';
$pagina     = $_GET['pagina']     ?? 1;
$porPagina  = 10;
$inicio     = ($pagina - 1) * $porPagina;

$condiciones = [];

/* Filtro por estado */
if ($estado !== '') {
    $condiciones[] = "estado = '$estado'";
}

/* Filtro por prioridad */
if ($prioridad !== '') {
    $condiciones[] = "prioridad_impacto = '$prioridad'";
}

/* Buscador */
if ($buscar !== '') {
    $condiciones[] = "(incidencia_problema LIKE '%$buscar%' 
                       OR creado_por LIKE '%$buscar%' 
                       OR asignado_a LIKE '%$buscar%')";
}

$where = count($condiciones) ? "WHERE " . implode(" AND ", $condiciones) : "";

/* ============================
   2. TOTAL PARA PAGINACIÓN
============================ */
$total = $conexion->query("SELECT COUNT(*) AS total FROM incidencias $where")
                  ->fetch_assoc()['total'];

$paginas = ceil($total / $porPagina);

/* ============================
   3. CONSULTA PRINCIPAL
============================ */
$resultado = $conexion->query("
    SELECT *
    FROM incidencias
    $where
    ORDER BY fecha_apertura DESC
    LIMIT $inicio, $porPagina
");

/* ============================
   4. CONSULTAS PARA DASHBOARD
============================ */
$estados = $conexion->query("
    SELECT estado, COUNT(*) AS total
    FROM incidencias
    GROUP BY estado
");

$prioridades = $conexion->query("
    SELECT prioridad_impacto, COUNT(*) AS total
    FROM incidencias
    GROUP BY prioridad_impacto
");

$por_mes = $conexion->query("
    SELECT DATE_FORMAT(fecha_apertura, '%Y-%m') AS mes, COUNT(*) AS total
    FROM incidencias
    GROUP BY mes
    ORDER BY mes ASC
");
?>

<div class="contenedor">

    <h1>Control de incidencias</h1>

    <!-- ============================
         FILTROS + BUSCADOR
    ============================= -->
    <form method="get" class="filtros" style="display:flex; gap:10px; margin-bottom:15px;">

        <select name="estado">
            <option value="">Estado</option>
            <option value="ABIERTA"     <?= $estado=='ABIERTA'?'selected':'' ?>>Abierta</option>
            <option value="EN PROCESO"  <?= $estado=='EN PROCESO'?'selected':'' ?>>En proceso</option>
            <option value="RESUELTA"    <?= $estado=='RESUELTA'?'selected':'' ?>>Resuelta</option>
            <option value="CERRADA"     <?= $estado=='CERRADA'?'selected':'' ?>>Cerrada</option>
        </select>

        <select name="prioridad">
            <option value="">Prioridad</option>
            <option value="BAJA"    <?= $prioridad=='BAJA'?'selected':'' ?>>Baja</option>
            <option value="MEDIA"   <?= $prioridad=='MEDIA'?'selected':'' ?>>Media</option>
            <option value="ALTA"    <?= $prioridad=='ALTA'?'selected':'' ?>>Alta</option>
            <option value="CRÍTICA" <?= $prioridad=='CRÍTICA'?'selected':'' ?>>Crítica</option>
        </select>

        <input type="text" name="buscar" placeholder="Buscar..." value="<?= $buscar ?>" style="padding:6px;">

        <button class="btn btn-primario">Aplicar</button>
    </form>

    <!-- ============================
         BOTONES DE EXPORTACIÓN
    ============================= -->
    <div style="margin-bottom:15px;">
        <a href="exportar_excel.php" class="btn btn-secundario">Exportar Excel</a>
        <a href="exportar_pdf.php" class="btn btn-secundario">Exportar PDF</a>
    </div>

    <!-- ============================
         TABLA PRINCIPAL
    ============================= -->
    <table>
        <thead>
        <tr>
            <th>Acciones</th>
            <th>No</th>
            <th>Incidencia</th>
            <th>Prioridad</th>
            <th>Fecha apertura</th>
            <th>Creado por</th>
            <th>Asignado a</th>
            <th>Fecha resolución</th>
            <th>Estado</th>
            <th>Corregido</th>
        </tr>
        </thead>

        <tbody>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><a href="editar_incidencia.php?id=<?= $fila['id'] ?>" class="btn-secundario">Editar</a></td>
                <td><?= $fila['id'] ?></td>
                <td><?= nl2br(htmlspecialchars($fila['incidencia_problema'])) ?></td>
                <td><?= $fila['prioridad_impacto'] ?></td>
                <td><?= $fila['fecha_apertura'] ?></td>
                <td><?= htmlspecialchars($fila['creado_por']) ?></td>
                <td><?= htmlspecialchars($fila['asignado_a']) ?></td>
                <td><?= $fila['fecha_resolucion'] ?: '-' ?></td>
                <td><?= $fila['estado'] ?></td>
                <td><input type="checkbox" disabled <?= $fila['corregido']?'checked':'' ?>></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- ============================
         PAGINACIÓN
    ============================= -->
    <div class="paginacion" style="margin-top:20px;">
        <?php for ($i = 1; $i <= $paginas; $i++): ?>
            <a href="?pagina=<?= $i ?>&estado=<?= $estado ?>&prioridad=<?= $prioridad ?>&buscar=<?= $buscar ?>"
               class="btn"
               style="background:#e0e0e0; color:#333; margin:2px;">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>

    <!-- ============================
         DASHBOARD
    ============================= -->
    <div class="dashboard" style="margin-top:40px;">
        <h2>Dashboard de incidencias</h2>

        <canvas id="graficaEstados" height="100"></canvas>
        <canvas id="graficaPrioridades" height="100"></canvas>
        <canvas id="graficaMeses" height="100"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ============================
   GRÁFICA DE ESTADOS
============================ */
new Chart(document.getElementById('graficaEstados'), {
    type: 'pie',
    data: {
        labels: [
            <?php while ($e = $estados->fetch_assoc()) echo "'{$e['estado']}',"; ?>
        ],
        datasets: [{
            data: [
                <?php
                $estados->data_seek(0);
                while ($e = $estados->fetch_assoc()) echo "{$e['total']},";
                ?>
            ],
            backgroundColor: ['#d32f2f','#c3922e','#2e7d32','#455a64']
        }]
    }
});

/* ============================
   GRÁFICA DE PRIORIDADES
============================ */
new Chart(document.getElementById('graficaPrioridades'), {
    type: 'bar',
    data: {
        labels: [
            <?php while ($p = $prioridades->fetch_assoc()) echo "'{$p['prioridad_impacto']}',"; ?>
        ],
        datasets: [{
            label: 'Total',
            data: [
                <?php
                $prioridades->data_seek(0);
                while ($p = $prioridades->fetch_assoc()) echo "{$p['total']},";
                ?>
            ],
            backgroundColor: '#006341'
        }]
    }
});

/* ============================
   GRÁFICA POR MES
============================ */
new Chart(document.getElementById('graficaMeses'), {
    type: 'line',
    data: {
        labels: [
            <?php while ($m = $por_mes->fetch_assoc()) echo "'{$m['mes']}',"; ?>
        ],
        datasets: [{
            label: 'Incidencias por mes',
            data: [
                <?php
                $por_mes->data_seek(0);
                while ($m = $por_mes->fetch_assoc()) echo "{$m['total']},";
                ?>
            ],
            borderColor: '#004731',
            backgroundColor: 'rgba(0,99,49,0.2)',
            tension: 0.3
        }]
    }
});
</script>

<?php include 'pie.php'; ?>
