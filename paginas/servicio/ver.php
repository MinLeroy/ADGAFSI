<?php
include_once(__DIR__ . "/../../datos/servicioDatos.php");

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<div class='message error'>No se especificó servicio.</div>";
    exit;
}

$servicio = obtenerServicioPorId($conn, $id);
if (!$servicio) {
    echo "<div class='message error'>Servicio no encontrado.</div>";
    exit;
}
?>

<div class="card">
    <div class="card-header">
        <i class="ri-eye-line"></i> Detalles del Servicio
    </div>

    <div class="card-body">

        <div class="client-details-grid">

            <div class="detail-item"><strong>ID:</strong> <?= $servicio['id_servicio'] ?></div>
            <div class="detail-item"><strong>Nombre:</strong> <?= htmlspecialchars($servicio['nombre_servicio']) ?></div>
            <div class="detail-item"><strong>Tipo:</strong> <?= htmlspecialchars($servicio['tipo_servicio']) ?></div>
            <div class="detail-item"><strong>Velocidad:</strong> <?= htmlspecialchars($servicio['velocidad_megas']) ?> Mbps</div>
            <div class="detail-item"><strong>Primer Mes:</strong> $<?= number_format($servicio['costo_primer_mes'], 2) ?></div>
            <div class="detail-item"><strong>Costo Regular:</strong> $<?= number_format($servicio['costo_regular'], 2) ?></div>
            <div class="detail-item"><strong>Instalación:</strong> <?= $servicio['requiere_instalacion'] ? 'Sí' : 'No' ?></div>
            <div class="detail-item"><strong>Estado:</strong> <?= $servicio['estado_servicio'] ? 'Activo' : 'Inactivo' ?></div>

            <div class="detail-item full-width">
                <strong>Descripción:</strong><br>
                <?= nl2br(htmlspecialchars($servicio['descripcion_servicio'] ?? '—')) ?>
            </div>

        </div>

        <div class="actions">
            <a href="home.php?page=servicio/editar&id=<?= $servicio['id_servicio'] ?>" class="btn btn-warning">
                <i class="ri-edit-line"></i> Editar
            </a>

            <a href="home.php?page=servicio" class="btn btn-secondary">
                <i class="ri-arrow-go-back-line"></i> Volver
            </a>
        </div>

    </div>
</div>

<style>
.client-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}
.detail-item {
    background: #0f0f0f;
    padding: 12px 14px;
    border-radius: 8px;
    color: #ddd;
    box-shadow: 0 2px 6px rgba(0,0,0,0.4);
}
.detail-item.full-width {
    grid-column: 1 / -1;
}
</style>
