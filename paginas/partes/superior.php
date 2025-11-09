<div class="content-header">
    <h2>
        <?php 
        $titulos = [
            'panel' => 'Panel Principal',
            'cliente' => 'Gestión de Clientes',
            'servicio' => 'Gestión de Servicios',
            'empleado' => 'Gestión de Empleados',
            'contrato' => 'Gestión de Contratos',
            'zona' => 'Zonas de Cobertura',
            'instalacion' => 'Gestión de Instalaciones',
            'pago' => 'Gestión de Pagos',
            'articulo' => 'Inventario de Artículos'
        ];
        echo $titulos[$page] ?? 'Panel Principal';
        ?>
    </h2>
</div>
