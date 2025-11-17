<?php
include_once(__DIR__ . "/../../datos/zonaDatos.php");

$id = $_GET['id'] ?? null;
$zona = obtenerZonaPorId($conn, $id);
?>

<div class="card">
    <div class="card-header">
        <i class="ri-map-pin-line"></i> Detalles de la Zona
    </div>

    <div class="card-body">
        <div class="client-details-grid">

            <div class="detail-item"><strong>ID:</strong> <?= $zona['id_zona'] ?></div>

            <div class="detail-item"><strong>Nombre:</strong> <?= htmlspecialchars($zona['nombre_zona']) ?></div>

            <div class="detail-item"><strong>Dirección:</strong> <?= htmlspecialchars($zona['direccion_zona'] ?? '—') ?></div>

            <div class="detail-item"><strong>Capacidad (Mbps):</strong> <?= htmlspecialchars($zona['capacidad_megas'] ?? '—') ?></div>

            <div class="detail-item full-width"><strong>Descripción:</strong><br>
                <?= nl2br(htmlspecialchars($zona['descripcion_zona'] ?? '—')) ?>
            </div>

        </div>

        <div class="actions">
            <a class="btn btn-warning" href="home.php?page=zona/editar&id=<?= $zona['id_zona'] ?>">
                <i class="ri-edit-line"></i> Editar
            </a>
            <a class="btn btn-secondary" href="home.php?page=zona">
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
