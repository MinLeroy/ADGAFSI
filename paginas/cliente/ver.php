<?php
include_once("datos/clienteDatos.php");

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<div class='message error'>No se especificó cliente.</div>";
    exit;
}

$cliente = obtenerClientePorId($conn, $id);
if (!$cliente) {
    echo "<div class='message error'>Cliente no encontrado.</div>";
    exit;
}
?>

<div class="card">
    <div class="card-header">
        <i class="ri-user-line"></i> Detalles del Cliente
    </div>

    <div class="card-body">
        <div class="client-details">
            <p><strong>Nombre:</strong> <?= $cliente['nombre_cliente'] . ' ' . $cliente['apellido_paterno'] . ' ' . $cliente['apellido_materno'] ?></p>
            <p><strong>Teléfono:</strong> <?= $cliente['telefono1'] ?> <?= $cliente['telefono2'] ? ' / ' . $cliente['telefono2'] : '' ?></p>
            <p><strong>Correo:</strong> <?= $cliente['correo_cliente'] ?></p>
            <p><strong>Dirección:</strong> <?= $cliente['calle'] . ' ' . $cliente['numero'] . ', ' . $cliente['colonia'] . ', ' . $cliente['municipio'] ?></p>
            <p><strong>Código Postal:</strong> <?= $cliente['codigo_postal'] ?></p>
            <p><strong>Zona:</strong> <?= $cliente['nombre_zona'] ?? '—' ?></p>
            <p><strong>Empleado Asignado:</strong> <?= $cliente['nombre_empleado'] ?? '—' ?></p>
            <p><strong>Estatus:</strong> <?= $cliente['estatus_cliente'] ?></p>
            <p><strong>Observaciones:</strong> <?= $cliente['observaciones'] ?></p>
        </div>

        <div class="actions">
            <a href="home.php?page=cliente" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Volver</a>
        </div>
    </div>
</div>
