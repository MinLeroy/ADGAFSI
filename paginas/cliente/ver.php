<?php
include_once(__DIR__ . "/../../datos/clienteDatos.php");

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
            <!-- Sección: Info general -->
            <div class="detail-item"><strong>Nombre:</strong> <?= htmlspecialchars(trim($cliente['nombre_cliente'] . ' ' . $cliente['apellido_paterno'] . ' ' . ($cliente['apellido_materno'] ?? ''))) ?></div>
            <div class="detail-item"><strong>ID:</strong> <?= $cliente['id_cliente'] ?></div>
            <div class="detail-item"><strong>Teléfono:</strong> <?= htmlspecialchars($cliente['telefono1']) ?> <?= $cliente['telefono2'] ? ' / ' . htmlspecialchars($cliente['telefono2']) : '' ?></div>
            <div class="detail-item"><strong>Correo:</strong> <?= htmlspecialchars($cliente['correo_cliente'] ?: '—') ?></div>
            <div class="detail-item"><strong>Estatus:</strong> <?= htmlspecialchars($cliente['estatus_cliente'] ?? '—') ?></div>
            <div class="detail-item"><strong>Fecha registro:</strong> <?= isset($cliente['fecha_registro_cliente']) ? date('d/m/Y H:i', strtotime($cliente['fecha_registro_cliente'])) : '—' ?></div>

            <!-- Sección: Ubicación -->
            <div class="detail-item"><strong>Calle:</strong> <?= htmlspecialchars($cliente['calle'] ?: '—') ?></div>
            <div class="detail-item"><strong>Número:</strong> <?= htmlspecialchars($cliente['numero'] ?: '—') ?></div>
            <div class="detail-item"><strong>Colonia:</strong> <?= htmlspecialchars($cliente['colonia'] ?: '—') ?></div>
            <div class="detail-item"><strong>Municipio:</strong> <?= htmlspecialchars($cliente['municipio'] ?: '—') ?></div>
            <div class="detail-item"><strong>Código Postal:</strong> <?= htmlspecialchars($cliente['codigo_postal'] ?: '—') ?></div>
            <div class="detail-item"><strong>Zona:</strong> <?= htmlspecialchars($cliente['nombre_zona'] ?? '—') ?></div>

            <!-- Sección: Servicio / IP -->
            <div class="detail-item"><strong>Servicio:</strong> <?= htmlspecialchars($cliente['nombre_servicio'] ?? '—') ?></div>
            <div class="detail-item"><strong>Tipo Servicio:</strong> <?= htmlspecialchars($cliente['tipo_servicio'] ?? '—') ?></div>
            <div class="detail-item"><strong>Velocidad:</strong> <?= htmlspecialchars($cliente['velocidad_megas'] ? $cliente['velocidad_megas'].' Mbps' : '—') ?></div>
            <div class="detail-item full-width"><strong>IP Cliente:</strong> <span style="display:inline-block; padding:8px 10px; background:#000; border-radius:6px; color:#00bcd4;"><?= htmlspecialchars($cliente['ip_cliente'] ?? '—') ?></span></div>

            <div class="detail-item full-width"><strong>Observaciones:</strong> <?= nl2br(htmlspecialchars($cliente['observaciones'] ?: '—')) ?></div>
        </div>

        <div class="actions">
            <a href="home.php?page=cliente/editar&id=<?= $cliente['id_cliente'] ?>" class="btn btn-warning">
                <i class="ri-edit-line"></i> Editar
            </a>
            <a href="home.php?page=cliente" class="btn btn-secondary">
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
.actions {
    text-align: right;
}
</style>
