<?php
// paginas/pago/ver.php
include_once(__DIR__ . "/../../datos/pagoDatos.php");
$id = $_GET['id'] ?? null;
if (!$id) { echo "<div class='message error'>No especificado.</div>"; exit; }
$p = obtenerPagoPorId($conn, $id);
if (!$p) { echo "<div class='message error'>No encontrado.</div>"; exit; }
?>

<div class="card">
    <div class="card-header"><i class="ri-money-dollar-circle-line"></i> Pago #<?= $p['id_pago'] ?></div>
    <div class="card-body">
        <div class="client-details-grid">
            <div class="detail-item"><strong>Cliente:</strong> <?= htmlspecialchars($p['cliente_nombre_completo'] ?? '—') ?></div>
            <div class="detail-item"><strong>Contrato ID:</strong> <?= htmlspecialchars($p['id_contrato'] ?? '—') ?></div>
            <div class="detail-item"><strong>Zona:</strong> <?= htmlspecialchars($p['zona'] ?? '—') ?></div>
            <div class="detail-item"><strong>Servicio:</strong> <?= htmlspecialchars($p['nombre_servicio'] ?? '—') ?></div>
            <div class="detail-item"><strong>Fecha Pago:</strong> <?= $p['fecha_pago'] ? date('d/m/Y H:i', strtotime($p['fecha_pago'])) : '—' ?></div>
            <div class="detail-item"><strong>Monto:</strong> $<?= number_format($p['monto_pago'] ?? 0, 2) ?></div>
            <div class="detail-item"><strong>Estatus:</strong> <?= htmlspecialchars($p['estatus_pago'] ?? '—') ?></div>

            <div class="detail-item full-width"><strong>Detalles del Cliente:</strong><br>
                Tel: <?= htmlspecialchars($p['telefono1'] ?? '—') ?> <?= $p['telefono2'] ? ' / ' . htmlspecialchars($p['telefono2']) : '' ?><br>
                Dirección: <?= htmlspecialchars((($p['calle'] ?? '') . ' ' . ($p['numero'] ?? '') . ', ' . ($p['colonia'] ?? '') . ' ' . ($p['municipio'] ?? ''))) ?>
            </div>
        </div>

        <div class="actions">
            <a href="paginas/pago/generar_pdf.php?id=<?= $p['id_pago'] ?>" target="_blank" class="btn btn-info"><i class="ri-file-download-line"></i> Generar PDF</a>
            <a href="home.php?page=pago/editar&id=<?= $p['id_pago'] ?>" class="btn btn-warning"><i class="ri-edit-line"></i> Editar</a>
            <a href="home.php?page=pago" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Volver</a>
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
.actions { text-align: right; }
</style>
