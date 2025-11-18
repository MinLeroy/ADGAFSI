<?php
include_once(__DIR__ . "/../../datos/articuloDatos.php");
$resumen = obtenerResumenArticulos($conn);
$articulos = obtenerArticulos($conn);
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['total'] ?></div>
        <div class="stat-label">Artículos Registrados</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['inventario'] ?></div>
        <div class="stat-label">Inventario Total</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['agotados'] ?></div>
        <div class="stat-label">Agotados</div>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="ri-box-3-line"></i> Artículos</div>
    <div class="card-body">

        <div class="actions mb-3">
            <a href="home.php?page=articulo/agregar" class="btn btn-primary">
                <i class="ri-add-circle-line"></i> Nuevo Artículo
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articulos as $a): ?>
                        <tr>
                            <td><?= htmlspecialchars($a['nombre_articulo']) ?></td>
                            <td><?= htmlspecialchars($a['marca_articulo']) ?></td>
                            <td><?= htmlspecialchars($a['tipo_articulo']) ?></td>
                            <td>$<?= number_format($a['precio_unitario'],2) ?></td>
                            <td><?= $a['cantidad_disponible'] ?></td>
                            <td class="text-center">
                                <a href="home.php?page=articulo/ver&id=<?= $a['id_articulo'] ?>" class="btn btn-sm btn-info">
                                    <i class="ri-eye-line"></i>
                                </a>

                                <a href="home.php?page=articulo/editar&id=<?= $a['id_articulo'] ?>" class="btn btn-sm btn-warning">
                                    <i class="ri-edit-line"></i>
                                </a>

                                <form action="/ADGAFSI/controles/articulo.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="id_articulo" value="<?= $a['id_articulo'] ?>">
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar artículo?')">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<!-- 🔹 Mensaje de acción -->
<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success mt-3">
        <?php
            if ($_GET['msg'] === 'ok') echo '✅ Artículo agregado correctamente.';
            elseif ($_GET['msg'] === 'editado') echo '✏️ Artículo actualizado correctamente.';
            elseif ($_GET['msg'] === 'eliminado') echo '🗑️ Artículo eliminado correctamente.';
        ?>
    </div>
<?php endif; ?>

