<?php
include_once("datos/empleadoDatos.php");
$empleados = obtenerEmpleados($conn);
?>

<div class="card">
    <div class="card-header">
        <i class="ri-briefcase-line"></i> Lista de Empleados
    </div>

    <div class="card-body">

        <div class="actions mb-3">
            <a href="home.php?page=empleado/agregar" class="btn btn-primary">
                <i class="ri-user-add-line"></i> Nuevo Empleado
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre completo</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Puesto</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (!empty($empleados)): ?>
                    <?php foreach ($empleados as $e): ?>
                    <tr>
                        <td><?= $e['id_empleado'] ?></td>

                        <td><?= htmlspecialchars(
                                $e['nombre_empleado'] . ' ' . 
                                $e['apellido_paterno'] . ' ' . 
                                ($e['apellido_materno'] ?? '')
                            ) ?></td>

                        <td><?= htmlspecialchars($e['telefono_empleado'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($e['correo_empleado'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($e['puesto'] ?? '—') ?></td>

                        <td>
                            <?php if ($e['estatus_empleado'] === 'Activo'): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?= htmlspecialchars($e['estatus_empleado']) ?></span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a class="btn btn-sm btn-info" href="home.php?page=empleado/ver&id=<?= $e['id_empleado'] ?>">
                                <i class="ri-eye-line"></i>
                            </a>

                            <a class="btn btn-sm btn-warning" href="home.php?page=empleado/editar&id=<?= $e['id_empleado'] ?>">
                                <i class="ri-edit-line"></i>
                            </a>

                            <form action="controles/empleado.php" method="POST" style="display:inline;">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id_empleado" value="<?= $e['id_empleado'] ?>">
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar empleado?')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">No hay empleados registrados.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success mt-3">
        <?php
            if ($_GET['msg'] === 'ok') echo '✅ Empleado agregado correctamente.';
            elseif ($_GET['msg'] === 'editado') echo '✏️ Empleado actualizado correctamente.';
            elseif ($_GET['msg'] === 'eliminado') echo '🗑️ Empleado eliminado correctamente.';
        ?>
    </div>
<?php endif; ?>

