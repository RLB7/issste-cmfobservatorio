<?php
require 'config.php';
require 'vendor/autoload.php'; // Ajusta si es necesario

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$resultado = $conexion->query("
    SELECT id, incidencia_problema, prioridad_impacto, fecha_apertura,
           creado_por, asignado_a, fecha_resolucion, estado, corregido
    FROM incidencias
    ORDER BY fecha_apertura DESC
");

$html = '
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h1 { text-align:center; color:#006341; font-size:16px; }
        table { width:100%; border-collapse: collapse; margin-top:10px; }
        th, td { border:1px solid #ccc; padding:4px; }
        th { background:#f0f0f0; }
    </style>
</head>
<body>
<h1>Control de incidencias – Reporte</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Incidencia</th>
        <th>Prioridad</th>
        <th>Fecha apertura</th>
        <th>Creado por</th>
        <th>Asignado a</th>
        <th>Fecha resolución</th>
        <th>Estado</th>
        <th>Corregido</th>
    </tr>';

while ($fila = $resultado->fetch_assoc()) {
    $corregido = $fila['corregido'] ? 'Sí' : 'No';
    $html .= '<tr>
        <td>'.$fila['id'].'</td>
        <td>'.htmlspecialchars($fila['incidencia_problema']).'</td>
        <td>'.$fila['prioridad_impacto'].'</td>
        <td>'.$fila['fecha_apertura'].'</td>
        <td>'.htmlspecialchars($fila['creado_por']).'</td>
        <td>'.htmlspecialchars($fila['asignado_a']).'</td>
        <td>'.($fila['fecha_resolucion'] ?: '-').'</td>
        <td>'.$fila['estado'].'</td>
        <td>'.$corregido.'</td>
    </tr>';
}

$html .= '
</table>
</body>
</html>';

$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("incidencias.pdf", ["Attachment" => true]);
