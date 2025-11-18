<div class="sidebar">
    <div class="sidebar-header">
        <h1>ADGAFSI</h1>
        <p style="text-align:center; color:#bbb; font-size:0.85rem;">
            Hola, <?php echo $_SESSION['usuario'] ?? 'Administrador'; ?>
        </p>
    </div>

    <ul class="nav-menu">
        <li class="nav-item"><a href="home.php?page=panel" class="nav-link"><i class="ri-home-3-line nav-icon"></i>Panel</a></li>
        <li class="nav-item"><a href="home.php?page=cliente" class="nav-link"><i class="ri-user-line nav-icon"></i>Clientes</a></li>
        <li class="nav-item"><a href="home.php?page=servicio" class="nav-link"><i class="ri-settings-3-line nav-icon"></i>Servicios</a></li>
        <li class="nav-item"><a href="home.php?page=empleado" class="nav-link"><i class="ri-user-settings-line nav-icon"></i>Empleados</a></li>
        <li class="nav-item"><a href="home.php?page=contrato" class="nav-link"><i class="ri-file-list-3-line nav-icon"></i>Contratos</a></li>
        <li class="nav-item"><a href="home.php?page=zona" class="nav-link"><i class="ri-earth-line nav-icon"></i>Zonas</a></li>
        <li class="nav-item"><a href="home.php?page=instalacion" class="nav-link"><i class="ri-router-line nav-icon"></i>Instalaciones</a></li>
        <li class="nav-item"><a href="home.php?page=pago" class="nav-link"><i class="ri-money-dollar-circle-line nav-icon"></i>Pagos</a></li>
        <li class="nav-item"><a href="home.php?page=articulo" class="nav-link"><i class="ri-box-3-line nav-icon"></i>Artículos</a></li>
        <li class="nav-item"><a href="index.php" class="nav-link"><i class="ri-logout-box-line nav-icon"></i> Cerrar Sesión</a></li>
    </ul>
</div>
