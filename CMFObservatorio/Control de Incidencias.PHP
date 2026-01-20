<?php
// Si en el futuro agregas sesiones o roles, aquí se inicializan.
// session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Incidencias – Inicio</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f5f7f8;
            margin: 0;
            padding: 0;
        }

        /* Encabezado institucional */
        .header-issste {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 20px;
            background: #ffffff;
            border-bottom: 6px solid #006341;
        }
        .logo-issste {
            height: 60px;
        }
        .titulo-sistema {
            font-size: 20px;
            font-weight: 700;
            color: #004731;
        }
        .titulo-sistema .sub {
            display: block;
            font-size: 12px;
            font-weight: 400;
            color: #666;
        }

        /* Contenido */
        .contenedor {
            max-width: 900px;
            margin: 40px auto;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-top: 6px solid #006341;
            border-radius: 6px;
            padding: 30px;
            text-align: center;
        }

        h1 {
            font-size: 22px;
            color: #004731;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        p {
            font-size: 14px;
            color: #555;
            margin-bottom: 25px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 300px;
            margin: 0 auto;
        }

        .btn {
            display: block;
            padding: 12px;
            background: #006341;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .btn:hover {
            opacity: .9;
        }

        /* Pie institucional */
        .pie-issste {
            margin-top: 40px;
            padding: 14px 10px;
            text-align: center;
            font-size: 11px;
            color: #ffffff;
            background: #006341;
            line-height: 1.4;
            letter-spacing: .3px;
        }
    </style>
</head>

<body>

<!-- Encabezado institucional -->
<div class="header-issste">
    <img src="logo_issste.png" alt="ISSSTE" class="logo-issste">
    <div class="titulo-sistema">
        CONTROL DE INCIDENCIAS
        <span class="sub">CMF OBSERVATORIO – USO INSTITUCIONAL</span>
    </div>
</div>

<!-- Contenido principal -->
<div class="contenedor">
    <h1>Bienvenido</h1>
    <p>Seleccione una opción para continuar con el sistema de control de incidencias.</p>

    <div class="menu">
        <a href="lista_incidencias.php" class="btn">Ver listado de incidencias</a>
        <a href="nueva_incidencia.php" class="btn">Registrar nueva incidencia</a>
    </div>
</div>

<!-- Pie institucional -->
<div class="pie-issste">
    © <?php echo date('Y'); ?> Instituto de Seguridad y Servicios Sociales de los Trabajadores del Estado  
    – CMF Observatorio – Uso interno
</div>

</body>
</html>

