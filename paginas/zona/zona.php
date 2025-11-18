<?php
include_once("datos/zonaDatos.php");
$zonas = obtenerZonas($conn);
?>

<div class="card">
    <div class="card-header">
        <i class="ri-map-pin-line"></i> Lista de Zonas
    </div>

    <div class="card-body">

        <div class="actions mb-3">
            <a href="home.php?page=zona/agregar" class="btn btn-primary">
                <i class="ri-add-circle-line"></i> Nueva Zona
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Zona</th>
                        <th>Dirección</th>
                        <th>Capacidad (Mbps)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (!empty($zonas)): ?>
                    <?php foreach ($zonas as $z): ?>
                    <tr>
                        <td><?= $z['id_zona'] ?></td>
                        <td><?= htmlspecialchars($z['nombre_zona']) ?></td>
                        <td><?= htmlspecialchars($z['direccion_zona'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($z['capacidad_megas'] ?? '—') ?></td>

                        <td>
                            <a class="btn btn-sm btn-info"
                               href="home.php?page=zona/ver&id=<?= $z['id_zona'] ?>">
                                <i class="ri-eye-line"></i>
                            </a>

                            <a class="btn btn-sm btn-warning"
                               href="home.php?page=zona/editar&id=<?= $z['id_zona'] ?>">
                                <i class="ri-edit-line"></i>
                            </a>

                            <form action="controles/zona.php" method="POST" style="display:inline;">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id_zona" value="<?= $z['id_zona'] ?>">
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar zona?')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No hay zonas registradas.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success mt-3">
        <?php
            if ($_GET['msg'] === 'ok') echo '✅ Zona agregada correctamente.';
            elseif ($_GET['msg'] === 'editado') echo '✏️ Zona actualizada correctamente.';
            elseif ($_GET['msg'] === 'eliminado') echo '🗑️ Zona eliminada correctamente.';
        ?>
    </div>
<?php endif; ?>
