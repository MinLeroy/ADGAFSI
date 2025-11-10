<?php
include_once("datos/clienteDatos.php");

// 🔹 Obtener resumen y lista de clientes
$resumen = resumenClientes($conn);
$clientes = obtenerClientes($conn);
?>

<!-- 🔹 Resumen general -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['activos'] ?? 0 ?></div>
        <div class="stat-label">Clientes Activos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['inactivos'] ?? 0 ?></div>
        <div class="stat-label">Clientes Inactivos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['nuevos_mes'] ?? 0 ?></div>
        <div class="stat-label">Nuevos del Mes</div>
    </div>
</div>

<!-- 🔹 Lista de clientes -->
<div class="card">
    <div class="card-header">
        <i class="ri-user-line"></i> Lista de Clientes
    </div>

    <div class="card-body">
        <!-- Botón agregar -->
        <div class="actions mb-3">
            <a href="home.php?page=cliente/agregar" class="btn btn-primary">
                <i class="ri-user-add-line"></i> Nuevo Cliente
            </a>
        </div>

        <!-- Tabla -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre completo</th>
                        <th>Teléfono</th>
                        <th>Zona</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($clientes)): ?>
                    <?php foreach ($clientes as $c): ?>
                    <tr>
                        <td><?= $c['id_cliente'] ?></td>
                        <td><?= htmlspecialchars($c['nombre_cliente'] . ' ' . $c['apellido_paterno'] . ' ' . ($c['apellido_materno'] ?? '')) ?></td>
                        <td><?= htmlspecialchars($c['telefono1']) ?></td>
                        <td><?= htmlspecialchars($c['nombre_zona'] ?? '—') ?></td>
                        <td>
                            <?php if ($c['estatus_cliente'] === 'Activo'): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?= htmlspecialchars($c['estatus_cliente']) ?></span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <!-- Ver -->
                            <a href="home.php?page=cliente/ver&id=<?= $c['id_cliente'] ?>" class="btn btn-sm btn-info" title="Ver">
                                <i class="ri-eye-line"></i>
                            </a>

                            <!-- Editar -->
                            <a href="home.php?page=cliente/editar&id=<?= $c['id_cliente'] ?>" class="btn btn-sm btn-warning">
                                <i class="ri-edit-line"></i>
                            </a>


                            <!-- Eliminar -->
                            <form action="controles/cliente.php" method="POST" style="display:inline;">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id_cliente" value="<?= $c['id_cliente'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                    onclick="return confirm('¿Seguro que deseas eliminar este cliente?');">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No hay clientes registrados.</td></tr>
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
            if ($_GET['msg'] === 'ok') echo '✅ Cliente agregado correctamente.';
            elseif ($_GET['msg'] === 'editado') echo '✏️ Cliente actualizado correctamente.';
            elseif ($_GET['msg'] === 'eliminado') echo '🗑️ Cliente eliminado correctamente.';
        ?>
    </div>
<?php endif; ?>
