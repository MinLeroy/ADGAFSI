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
        <div class="client-details-grid">
            <div class="detail-item"><strong>Nombre:</strong> <?= $cliente['nombre_cliente'] . ' ' . $cliente['apellido_paterno'] . ' ' . $cliente['apellido_materno'] ?></div>
            <div class="detail-item"><strong>Teléfono:</strong> <?= $cliente['telefono1'] ?> <?= $cliente['telefono2'] ? ' / ' . $cliente['telefono2'] : '' ?></div>
            <div class="detail-item"><strong>Correo:</strong> <?= $cliente['correo_cliente'] ?></div>
            <div class="detail-item"><strong>Calle:</strong> <?= $cliente['calle'] ?></div>
            <div class="detail-item"><strong>Número:</strong> <?= $cliente['numero'] ?></div>
            <div class="detail-item"><strong>Colonia:</strong> <?= $cliente['colonia'] ?></div>
            <div class="detail-item"><strong>Municipio:</strong> <?= $cliente['municipio'] ?></div>
            <div class="detail-item"><strong>Código Postal:</strong> <?= $cliente['codigo_postal'] ?></div>
            <div class="detail-item"><strong>Zona:</strong> <?= $cliente['nombre_zona'] ?? '—' ?></div>
            <div class="detail-item"><strong>Empleado Asignado:</strong> <?= $cliente['nombre_empleado'] ?? '—' ?></div>
            <div class="detail-item"><strong>Estatus:</strong> <?= $cliente['estatus_cliente'] ?></div>
            <div class="detail-item full-width"><strong>Observaciones:</strong> <?= $cliente['observaciones'] ?: '—' ?></div>
        </div>

        <div class="actions">
            <a href="home.php?page=cliente" class="btn btn-secondary">
                <i class="ri-arrow-go-back-line"></i> Volver
            </a>
        </div>
    </div>
</div>
<style>
.client-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 10px;
    margin-bottom: 20px;
}
.detail-item {
    background: #000000ff;
    padding: 10px 15px;
    border-radius: 5px;
}
.detail-item.full-width {
    grid-column: 1 / -1;
}
.actions {
    text-align: right;
}
</style>