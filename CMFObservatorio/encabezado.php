<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <title>Control de incidencias</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background-color: #f5f7f8;
            margin: 0;
        }
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
        .layout {
            display: grid;
            grid-template-columns: 230px 1fr;
            min-height: calc(100vh - 80px);
        }
        .main-sidebar {
            background-color: #f5f5f5;
            border-right: 1px solid #e0e0e0;
            padding: 16px;
            font-size: 14px;
        }
        .main-sidebar h2 {
            font-size: 13px;
            text-transform: uppercase;
            color: #555;
            margin-bottom: 10px;
        }
        .main-sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .main-sidebar li {
            margin-bottom: 8px;
        }
        .main-sidebar a {
            text-decoration: none;
            color: #212529;
            font-size: 13px;
        }
        .main-sidebar a:hover {
            text-decoration: underline;
        }
        .main-content {
            padding: 20px;
        }
        .pie-issste {
            padding: 12px;
            text-align: center;
            font-size: 11px;
            color: #ffffff;
            background: #006341;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-primario {
            background-color: #006341;
            color: #ffffff;
        }
        .btn-secundario {
            background-color: #c3922e;
            color: #ffffff;
        }
    </style>
</head>
<body>

<div class="header-issste">
    <img src="logo_issste.png" alt="Logotipo oficial del ISSSTE" class="logo-issste">
    <div class="titulo-sistema">
        CONTROL DE INCIDENCIAS
        <span class="sub">CMF OBSERVATORIO – USO INSTITUCIONAL</span>
    </div>
</div>

<div class="layout">
    <aside class="main-sidebar">
        <h2>Menú</h2>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="lista_incidencias.php">Listado de incidencias</a></li>
            <li><a href="nueva_incidencia.php">Registrar nueva incidencia</a></li>
            <li><a href="lista_incidencias.php?estado=ABIERTA">Incidencias abiertas</a></li>
            <li><a href="lista_incidencias.php?estado=EN PROCESO">En proceso</a></li>
            <li><a href="lista_incidencias.php?estado=RESUELTA">Resueltas</a></li>
            <li><a href="lista_incidencias.php?estado=CERRADA">Cerradas</a></li>
            <li><a href="lista_incidencias.php">Dashboard</a></li>
        </ul>
    </aside>

    <main class="main-content">
