<?php
include_once("datos/servicioDatos.php");

// 🔹 Obtener resumen y lista de servicios
$resumen = resumenServicios($conn);
$servicios = obtenerServicios($conn);
?>

<!-- 🔹 Resumen general -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['activos'] ?? 0 ?></div>
        <div class="stat-label">Servicios Activos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['inactivos'] ?? 0 ?></div>
        <div class="stat-label">Servicios Inactivos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['requieren_instalacion'] ?? 0 ?></div>
        <div class="stat-label">Requieren Instalación</div>
</div>

</div>

<!-- 🔹 Lista de servicios -->
<div class="card">
    <div class="card-header">
        <i class="ri-wifi-line"></i> Lista de Servicios
    </div>

    <div class="card-body">
        <!-- Botón agregar -->
        <div class="actions mb-3">
            <a href="home.php?page=servicio/agregar" class="btn btn-primary">
                <i class="ri-add-circle-line"></i> Nuevo Servicio
            </a>
        </div>

        <!-- Tabla -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Velocidad</th>
                        <th>Costo Regular</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (!empty($servicios)): ?>
                    <?php foreach ($servicios as $s): ?>
                    <tr>
                        <td><?= $s['id_servicio'] ?></td>
                        <td><?= htmlspecialchars($s['nombre_servicio']) ?></td>
                        <td><?= htmlspecialchars($s['tipo_servicio']) ?></td>
                        <td><?= htmlspecialchars($s['velocidad_megas']) ?> Mbps</td>
                        <td>$<?= number_format($s['costo_regular'], 2) ?></td>

                        <td>
                            <?php if ($s['estado_servicio'] == 1): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactivo</span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <!-- Ver -->
                            <a href="home.php?page=servicio/ver&id=<?= $s['id_servicio'] ?>" 
                               class="btn btn-sm btn-info" title="Ver">
                                <i class="ri-eye-line"></i>
                            </a>

                            <!-- Editar -->
                            <a href="home.php?page=servicio/editar&id=<?= $s['id_servicio'] ?>" 
                               class="btn btn-sm btn-warning">
                                <i class="ri-edit-line"></i>
                            </a>

                            <!-- Eliminar -->
                            <form action="controles/servicio.php" method="POST" style="display:inline;">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id_servicio" value="<?= $s['id_servicio'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                    onclick="return confirm('¿Seguro que deseas eliminar este servicio?');">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">No hay servicios registrados.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 🔹 Mensaje de acción -->
<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success mt-3">
        <?php
            if ($_GET['msg'] === 'ok') echo '✅ Servicio agregado correctamente.';
            elseif ($_GET['msg'] === 'editado') echo '✏️ Servicio actualizado correctamente.';
            elseif ($_GET['msg'] === 'eliminado') echo '🗑️ Servicio eliminado correctamente.';
        ?>
    </div>
<?php endif; ?>
