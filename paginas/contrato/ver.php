<?php
// paginas/contrato/ver.php
include_once(__DIR__ . "/../../datos/contratoDatos.php");
$id = $_GET['id'] ?? null;
if (!$id) { echo "<div class='message error'>No especificado.</div>"; exit; }
$ct = obtenerContratoPorId($conn, $id);
if (!$ct) { echo "<div class='message error'>No encontrado.</div>"; exit; }
?>

<div class="card">
    <div class="card-header"><i class="ri-file-list-3-line"></i> Contrato #<?= $ct['id_contrato'] ?></div>
    <div class="card-body">
        <div class="client-details-grid">
            <div class="detail-item"><strong>Cliente:</strong> <?= htmlspecialchars($ct['cliente_nombre_completo'] ?? '—') ?></div>
            <div class="detail-item"><strong>Zona:</strong> <?= htmlspecialchars($ct['zona'] ?? '—') ?></div>
            <div class="detail-item"><strong>Dirección:</strong> <?= htmlspecialchars((($ct['calle'] ?? '') . ' ' . ($ct['numero'] ?? '') . ', ' . ($ct['colonia'] ?? ''))) ?></div>
            <div class="detail-item"><strong>Servicio:</strong> <?= htmlspecialchars($ct['nombre_servicio'] ?? '—') ?> (<?= htmlspecialchars($ct['tipo_servicio'] ?? '') ?>)</div>
            <div class="detail-item"><strong>Velocidad:</strong> <?= htmlspecialchars($ct['velocidad_megas'] ?? '—') ?> <?= ($ct['velocidad_megas'] ? 'Mbps' : '') ?></div>
            <div class="detail-item"><strong>Empleado:</strong> <?= htmlspecialchars($ct['empleado_nombre_completo'] ?? '—') ?></div>
            <div class="detail-item"><strong>Fecha:</strong> <?= $ct['fecha_contrato'] ? date('d/m/Y H:i', strtotime($ct['fecha_contrato'])) : '—' ?></div>
            <div class="detail-item"><strong>Monto:</strong> $<?= number_format($ct['monto_total'] ?? 0, 2) ?></div>
            <div class="detail-item"><strong>Estatus:</strong> <?= htmlspecialchars($ct['estatus_contrato'] ?? '—') ?></div>
            <div class="detail-item"><strong>Estado Instalación:</strong> <?= htmlspecialchars($ct['instalacion_estatus'] ?? ($ct['estado_instalacion'] ?? '—')) ?></div>
            <div class="detail-item full-width"><strong>Observaciones:</strong><br><?= nl2br(htmlspecialchars($ct['observaciones'] ?? '—')) ?></div>

            <?php if (!empty($ct['id_instalacion'])): ?>
                <div class="detail-item full-width">
                    <strong>Instalación (ID <?= $ct['id_instalacion'] ?>):</strong><br>
                    Fecha Programada: <?= $ct['fecha_programada'] ? date('d/m/Y H:i', strtotime($ct['fecha_programada'])) : '—' ?><br>
                    Fecha Realizada: <?= $ct['fecha_realizada'] ? date('d/m/Y H:i', strtotime($ct['fecha_realizada'])) : '—' ?><br>
                    Comentarios: <?= nl2br(htmlspecialchars($ct['comentarios_instalacion'] ?? '—')) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="actions">
            <a href="paginas/contrato/generar_pdf.php?id=<?= $ct['id_contrato'] ?>" target="_blank" class="btn btn-info"><i class="ri-file-download-line"></i> Generar PDF</a>
            <a href="home.php?page=contrato/editar&id=<?= $ct['id_contrato'] ?>" class="btn btn-warning"><i class="ri-edit-line"></i> Editar</a>
            <a href="home.php?page=contrato" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Volver</a>
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
