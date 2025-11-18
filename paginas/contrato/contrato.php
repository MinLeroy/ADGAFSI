<?php
// paginas/contrato/contrato.php
include_once(__DIR__ . "/../../datos/contratoDatos.php");
$resumen = resumenContratos($conn);
$contratos = obtenerContratos($conn);
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['activos'] ?? 0 ?></div>
        <div class="stat-label">Contratos Activos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['cancelados'] ?? 0 ?></div>
        <div class="stat-label">Cancelados</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['nuevos_mes'] ?? 0 ?></div>
        <div class="stat-label">Nuevos (mes)</div>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="ri-file-list-3-line"></i> Contratos</div>
    <div class="card-body">
        <div class="actions mb-3">
            <a href="home.php?page=contrato/agregar" class="btn btn-primary"><i class="ri-add-circle-line"></i> Nuevo Contrato</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Estatus</th>
                        <th>Instalación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($contratos)): ?>
                    <?php foreach ($contratos as $ct): ?>
                    <tr>
                        <td><?= htmlspecialchars($ct['cliente_nombre_completo'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($ct['nombre_servicio'] ?? '—') ?></td>
                        <td><span class="badge"><?= htmlspecialchars($ct['estatus_contrato'] ?? '') ?></span></td>
                        <td><?= htmlspecialchars($ct['instalacion_estatus'] ?? ($ct['estado_instalacion'] ?? '—')) ?></td>
                        <td class="text-center">
                            <a href="home.php?page=contrato/ver&id=<?= $ct['id_contrato'] ?>" class="btn btn-sm btn-info" title="Ver"><i class="ri-eye-line"></i></a>
                            <a href="home.php?page=contrato/editar&id=<?= $ct['id_contrato'] ?>" class="btn btn-sm btn-warning" title="Editar"><i class="ri-edit-line"></i></a>

                            <form action="paginas/contrato/generar_pdf.php" method="GET" style="display:inline;" target="_blank">
                                <input type="hidden" name="id" value="<?= $ct['id_contrato'] ?>">
                                <button type="submit" class="btn btn-sm btn-info" title="Generar PDF"><i class="ri-file-download-line"></i></button>
                            </form>

                            <form action="controles/contrato.php" method="POST" style="display:inline;">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id_contrato" value="<?= $ct['id_contrato'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Eliminar contrato?');"><i class="ri-delete-bin-line"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No hay contratos.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success mt-3">
        <?php
            if ($_GET['msg'] === 'ok') echo '✅ Contrato agregado correctamente.';
            elseif ($_GET['msg'] === 'editado') echo '✏️ Contrato actualizado correctamente.';
            elseif ($_GET['msg'] === 'eliminado') echo '🗑️ Contrato eliminado correctamente.';
        ?>
    </div>
<?php endif; ?>
