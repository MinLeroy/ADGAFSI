<?php
// ========================================
// CONFIGURACIÓN DE PÁGINA ACTUAL
// ========================================
$page = isset($_GET['page']) ? $_GET['page'] : 'panel';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ADGAFSI - HIFIBER</title>
    <link rel="stylesheet" href="visual/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css">
</head>

<body>
<div class="app-container">
    
    <!-- MENÚ LATERAL -->
    <?php include('paginas/partes/menu.php'); ?>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="main-content">
        <?php include('paginas/partes/superior.php'); ?>

        <div class="content-body">
            <?php
            // ========================================
            // SISTEMA DE RUTAS DINÁMICO
            // ========================================

            // Intenta cargar directamente la ruta (ej: paginas/cliente/agregar.php)
            $rutaDirecta = "paginas/$page.php";

            // Si no existe, intenta el formato carpeta/página (ej: paginas/cliente/cliente.php)
            $partes = explode('/', $page);
            $carpeta = $partes[0] ?? '';
            $archivo = end($partes);
            $rutaAlterna = "paginas/$carpeta/$archivo.php";

            if (file_exists($rutaDirecta)) {
                include($rutaDirecta);
            } elseif (file_exists($rutaAlterna)) {
                include($rutaAlterna);
            } else {
                echo "<p style='padding:20px;'>⚠️ Página no encontrada: <strong>$page</strong></p>";
            }
            ?>
        </div>

        <?php include('paginas/partes/inferior.php'); ?>
    </div>
</div>
</body>
</html>
