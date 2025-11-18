<?php
// paginas/instalacion/instalacion.php
include_once(__DIR__ . "/../../datos/instalacionDatos.php");
$resumen = resumenInstalaciones($conn);
$instalaciones = obtenerInstalaciones($conn);
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['pendientes'] ?? 0 ?></div>
        <div class="stat-label">Instalaciones Pendientes</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['realizadas'] ?? 0 ?></div>
        <div class="stat-label">Instalaciones Realizadas</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['programadas_mes'] ?? 0 ?></div>
        <div class="stat-label">Programadas (mes)</div>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="ri-wifi-line"></i> Instalaciones</div>
    <div class="card-body">
        <div class="actions mb-3">
            <a href="home.php?page=instalacion/agregar" class="btn btn-primary"><i class="ri-add-circle-line"></i> Nueva Instalación</a>
        </div>

        <div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Técnico</th>
                <th>Fecha Programada</th>
                <th>Estatus</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($instalaciones)): ?>
            <?php foreach ($instalaciones as $it): ?>
            <tr>
                <td><?= htmlspecialchars($it['cliente_nombre_completo'] ?? '—') ?></td>
                <td><?= htmlspecialchars($it['tecnico_nombre_completo'] ?? '—') ?></td>
                <td><?= $it['fecha_programada'] ? date('d/m/Y H:i', strtotime($it['fecha_programada'])) : '—' ?></td>
                <td><span class="badge"><?= htmlspecialchars($it['estatus_instalacion'] ?? '') ?></span></td>

                <td class="text-center">
                    <a href="home.php?page=instalacion/ver&id=<?= $it['id_instalacion'] ?>" class="btn btn-sm btn-info" title="Ver">
                        <i class="ri-eye-line"></i>
                    </a>

                    <a href="home.php?page=instalacion/editar&id=<?= $it['id_instalacion'] ?>" class="btn btn-sm btn-warning" title="Editar">
                        <i class="ri-edit-line"></i>
                    </a>

                    <form action="controles/instalacion.php" method="POST" style="display:inline;">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id_instalacion" value="<?= $it['id_instalacion'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Eliminar instalación?');">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">No hay instalaciones.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success mt-3">
        <?php
            if ($_GET['msg'] === 'ok') echo '✅ Instalación agregado correctamente.';
            elseif ($_GET['msg'] === 'editado') echo '✏️ Instalación actualizado correctamente.';
            elseif ($_GET['msg'] === 'eliminado') echo '🗑️ Instalación eliminado correctamente.';
        ?>
    </div>
<?php endif; ?>

