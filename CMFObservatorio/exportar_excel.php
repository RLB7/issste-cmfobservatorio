<?php
require 'config.php';

// Opcional: podrías reutilizar filtros vía $_GET como en lista_incidencias.php

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=incidencias.xls");
header("Pragma: no-cache");
header("Expires: 0");

$resultado = $conexion->query("
    SELECT id, incidencia_problema, prioridad_impacto, fecha_apertura,
           creado_por, asignado_a, fecha_resolucion, estado, corregido
    FROM incidencias
    ORDER BY fecha_apertura DESC
");

echo "<table border='1'>";
echo "<tr>
        <th>ID</th>
        <th>Incidencia / problema</th>
        <th>Prioridad</th>
        <th>Fecha apertura</th>
        <th>Creado por</th>
        <th>Asignado a</th>
        <th>Fecha resolución</th>
        <th>Estado</th>
        <th>Corregido</th>
      </tr>";

while ($fila = $resultado->fetch_assoc()) {

    $corregido = $fila['corregido'] ? 'Sí' : 'No';

    echo "<tr>
            <td>{$fila['id']}</td>
            <td>".htmlspecialchars($fila['incidencia_problema'])."</td>
            <td>{$fila['prioridad_impacto']}</td>
            <td>{$fila['fecha_apertura']}</td>
            <td>".htmlspecialchars($fila['creado_por'])."</td>
            <td>".htmlspecialchars($fila['asignado_a'])."</td>
            <td>".($fila['fecha_resolucion'] ?: '-')."</td>
            <td>{$fila['estado']}</td>
            <td>{$corregido}</td>
          </tr>";
}

echo "</table>";
