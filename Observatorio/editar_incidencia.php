<?php
require 'config.php';

// Validar ID recibido
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die("ID inválido.");
}

// Obtener incidencia
$stmt = $conexion->prepare("SELECT * FROM incidencias WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$inc = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$inc) {
    die("Incidencia no encontrada.");
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $incidencia_problema = trim($_POST['incidencia_problema'] ?? '');
    $prioridad_impacto   = $_POST['prioridad_impacto'] ?? '';
    $asignado_a          = trim($_POST['asignado_a'] ?? '');
    $estado              = $_POST['estado'] ?? '';
    $corregido           = isset($_POST['corregido']) ? 1 : 0;

    // Validación de valores permitidos
    $prioridades_validas = ['BAJA','MEDIA','ALTA','CRÍTICA'];
    $estados_validos     = ['ABIERTA','EN PROCESO','RESUELTA','CERRADA'];

    if (!in_array($prioridad_impacto, $prioridades_validas)) {
        die("Prioridad no válida.");
    }

    if (!in_array($estado, $estados_validos)) {
        die("Estado no válido.");
    }

    if ($incidencia_problema === '') {
        die("La descripción de la incidencia no puede estar vacía.");
    }

    // Fecha de resolución automática
    $fecha_resolucion = ($estado === 'RESUELTA' || $estado === 'CERRADA')
        ? date('Y-m-d H:i:s')
        : null;

    // Actualizar incidencia
    $stmt = $conexion->prepare("
        UPDATE incidencias
        SET incidencia_problema=?, prioridad_impacto=?, asignado_a=?, estado=?, corregido=?, fecha_resolucion=?
        WHERE id=?
    ");

    if (!$stmt) {
        error_log("Error en prepare(): " . $conexion->error);
        die("Error interno.");
    }

    $stmt->bind_param(
        "ssssisi",
        $incidencia_problema,
        $prioridad_impacto,
        $asignado_a,
        $estado,
        $corregido,
        $fecha_resolucion,
        $id
    );

    if (!$stmt->execute()) {
        error_log("Error al actualizar incidencia ID $id: " . $stmt->error);
        die("No se pudo actualizar la incidencia.");
    }

    $stmt->close();

    header("Location: lista_incidencias.php");
    exit;
}

include 'encabezado.php';
?>

<div class="contenedor">
    <h1>Editar incidencia</h1>

    <form method="post" class="form-issste">

        <label>Incidencia / problema</label>
        <textarea name="incidencia_problema" required style="width:100%; height:120px;">
<?= htmlspecialchars($inc['incidencia_problema']) ?>
        </textarea>

        <div class="fila" style="display:flex; gap:20px; margin-top:15px;">
            <div style="flex:1;">
                <label>Prioridad / impacto</label>
                <select name="prioridad_impacto" required style="width:100%; padding:6px;">
                    <option value="BAJA"    <?= $inc['prioridad_impacto']=='BAJA'?'selected':'' ?>>BAJA</option>
                    <option value="MEDIA"   <?= $inc['prioridad_impacto']=='MEDIA'?'selected':'' ?>>MEDIA</option>
                    <option value="ALTA"    <?= $inc['prioridad_impacto']=='ALTA'?'selected':'' ?>>ALTA</option>
                    <option value="CRÍTICA" <?= $inc['prioridad_impacto']=='CRÍTICA'?'selected':'' ?>>CRÍTICA</option>
                </select>
            </div>

            <div style="flex:1;">
                <label>Asignado a</label>
                <input type="text" name="asignado_a" value="<?= htmlspecialchars($inc['asignado_a']) ?>" style="width:100%; padding:6px;">
            </div>
        </div>

        <div class="fila" style="display:flex; gap:20px; margin-top:15px;">
            <div style="flex:1;">
                <label>Estado</label>
                <select name="estado" required style="width:100%; padding:6px;">
                    <option value="ABIERTA"     <?= $inc['estado']=='ABIERTA'?'selected':'' ?>>ABIERTA</option>
                    <option value="EN PROCESO"  <?= $inc['estado']=='EN PROCESO'?'selected':'' ?>>EN PROCESO</option>
                    <option value="RESUELTA"    <?= $inc['estado']=='RESUELTA'?'selected':'' ?>>RESUELTA</option>
                    <option value="CERRADA"     <?= $inc['estado']=='CERRADA'?'selected':'' ?>>CERRADA</option>
                </select>
            </div>

            <div style="flex:1; display:flex; align-items:center; margin-top:20px;">
                <label style="display:flex; align-items:center; gap:6px;">
                    <input type="checkbox" name="corregido" <?= $inc['corregido'] ? 'checked' : '' ?>>
                    Marcar como corregido
                </label>
            </div>
        </div>

        <button type="submit" class="btn-primario" style="margin-top:20px;">Guardar cambios</button>

    </form>
</div>

<?php include 'pie.php'; ?>
