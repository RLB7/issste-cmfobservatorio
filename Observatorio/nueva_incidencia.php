<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $incidencia_problema = $_POST['incidencia_problema'] ?? '';
    $prioridad_impacto   = $_POST['prioridad_impacto'] ?? 'MEDIA';
    $creado_por          = $_POST['creado_por'] ?? '';
    $asignado_a          = $_POST['asignado_a'] ?? null;

    $stmt = $conexion->prepare("
        INSERT INTO incidencias (incidencia_problema, prioridad_impacto, creado_por, asignado_a)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("ssss", $incidencia_problema, $prioridad_impacto, $creado_por, $asignado_a);
    $stmt->execute();
    $stmt->close();

    header("Location: lista_incidencias.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva incidencia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css">
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background-color: #f5f7f8;
            margin: 0;
            padding: 20px;
        }
        .contenedor {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-top: 6px solid #006341; /* Verde institucional */
            border-radius: 6px;
            padding: 20px 30px;
        }
        h1 {
            font-size: 22px;
            margin-top: 0;
            color: #004731;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .subtitulo {
            font-size: 13px;
            color: #666666;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 4px;
            font-weight: 600;
            font-size: 13px;
            color: #333333;
        }
        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #cfd4d8;
            border-radius: 4px;
            font-size: 13px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        .fila {
            display: flex;
            gap: 15px;
        }
        .col-50 {
            flex: 1;
        }
        .acciones {
            margin-top: 20px;
            text-align: right;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            font-size: 13px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .btn-primario {
            background-color: #006341;
            color: #ffffff;
        }
        .btn-secundario {
            background-color: #c3922e;
            color: #ffffff;
            margin-right: 8px;
        }
        .btn:hover {
            opacity: .9;
        }
        a.enlace-lista {
            font-size: 12px;
            color: #006341;
            text-decoration: none;
        }
        a.enlace-lista:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Registro de incidencia</h1>
    <div class="subtitulo">
        Control de incidencias / problemas – Uso interno institucional
    </div>

    <form method="post">
        <label for="incidencia_problema">Incidencia / problema</label>
        <textarea name="incidencia_problema" id="incidencia_problema" required></textarea>

        <div class="fila">
            <div class="col-50">
                <label for="prioridad_impacto">Prioridad / impacto</label>
                <select name="prioridad_impacto" id="prioridad_impacto">
                    <option value="BAJA">Baja</option>
                    <option value="MEDIA" selected>Media</option>
                    <option value="ALTA">Alta</option>
                    <option value="CRÍTICA">Crítica</option>
                </select>
            </div>
            <div class="col-50">
                <label for="creado_por">Creado por</label>
                <input type="text" name="creado_por" id="creado_por" required>
            </div>
        </div>

        <div class="fila">
            <div class="col-50">
                <label for="asignado_a">Asignado a</label>
                <input type="text" name="asignado_a" id="asignado_a">
            </div>
        </div>

        <div class="acciones">
            <a href="lista_incidencias.php" class="enlace-lista">Ver listado de incidencias</a>
            <button type="submit" class="btn btn-primario">Guardar</button>
        </div>
    </form>
</div>
</body>
</html>
