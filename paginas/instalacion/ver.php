<?php
// paginas/instalacion/ver.php
include_once(__DIR__ . "/../../datos/instalacionDatos.php");
$id = $_GET['id'] ?? null;
if (!$id) { echo "<div class='message error'>No especificado.</div>"; exit; }
$it = obtenerInstalacionPorId($conn, $id);
if (!$it) { echo "<div class='message error'>No encontrado.</div>"; exit; }

$detalles = obtenerDetallesPorInstalacion($conn, $id);
?>

<div class="card">
    <div class="card-header"><i class="ri-wifi-line"></i> Instalación #<?= $it['id_instalacion'] ?></div>
    <div class="card-body">
        <div class="client-details-grid">
            <div class="detail-item"><strong>Cliente:</strong> <?= htmlspecialchars($it['cliente_nombre_completo'] ?? '—') ?></div>
            <div class="detail-item"><strong>Contrato ID:</strong> <?= htmlspecialchars($it['id_contrato'] ?? '—') ?></div>
            <div class="detail-item"><strong>Servicio:</strong> <?= htmlspecialchars($it['nombre_servicio'] ?? '—') ?> (<?= htmlspecialchars($it['tipo_servicio'] ?? '') ?>)</div>
            <div class="detail-item"><strong>Técnico:</strong> <?= htmlspecialchars($it['tecnico_nombre_completo'] ?? '—') ?></div>
            <div class="detail-item"><strong>Fecha Programada:</strong> <?= $it['fecha_programada'] ? date('d/m/Y H:i', strtotime($it['fecha_programada'])) : '—' ?></div>
            <div class="detail-item"><strong>Fecha Realizada:</strong> <?= $it['fecha_realizada'] ? date('d/m/Y H:i', strtotime($it['fecha_realizada'])) : '—' ?></div>
            <div class="detail-item"><strong>Estatus:</strong> <?= htmlspecialchars($it['estatus_instalacion'] ?? '—') ?></div>
            <div class="detail-item full-width"><strong>Comentarios:</strong><br><?= nl2br(htmlspecialchars($it['comentarios'] ?? '—')) ?></div>
        </div>

        <div class="card" style="margin-top:12px;">
            <div class="card-header">Material / Artículos usados</div>
            <div class="card-body">
                <?php if (!empty($detalles)): ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Fecha registro</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($detalles as $d): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($d['nombre_articulo'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($d['cantidad_usada'] ?? 0) ?></td>
                                        <td><?= $d['fecha_registro'] ? date('d/m/Y H:i', strtotime($d['fecha_registro'])) : '—' ?></td>
                                        <td><?= htmlspecialchars($d['estado_detalle'] ?? '—') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="message info">No hay registros de material para esta instalación.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="actions" style="margin-top:12px;">
            <a href="home.php?page=instalacion/editar&id=<?= $it['id_instalacion'] ?>" class="btn btn-warning"><i class="ri-edit-line"></i> Editar</a>
            <a href="home.php?page=instalacion" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Volver</a>
        </div>
    </div>
</div>

<style>
.client-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 12px;
    margin-bottom: 12px;
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
