<?php 
include_once(__DIR__ . "/../../datos/empleadoDatos.php"); 

$id = $_GET['id'] ?? null; 
$empleado = obtenerEmpleadoPorId($conn, $id); 
?>

<div class="card">
    <div class="card-header">
        <i class="ri-edit-line"></i> Editar Empleado
    </div>

    <div class="card-body">
        <form action="/ADGAFSI/controles/empleado.php" method="POST">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id_empleado" value="<?= $empleado['id_empleado'] ?>">

            <div class="form-grid">

                <div class="form-group">
                    <label>Apellido Paterno *</label>
                    <input type="text" name="apellido_paterno" value="<?= $empleado['apellido_paterno'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Apellido Materno</label>
                    <input type="text" name="apellido_materno" value="<?= $empleado['apellido_materno'] ?>">
                </div>

                <div class="form-group">
                    <label>Nombre *</label>
                    <input type="text" name="nombre_empleado" value="<?= $empleado['nombre_empleado'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="telefono_empleado" value="<?= $empleado['telefono_empleado'] ?>">
                </div>

                <div class="form-group">
                    <label>Correo</label>
                    <input type="email" name="correo_empleado" value="<?= $empleado['correo_empleado'] ?>">
                </div>

                <div class="form-group">
                    <label>Puesto</label>
                    <input type="text" name="puesto" value="<?= $empleado['puesto'] ?>">
                </div>

                <div class="form-group">
                    <label>Estatus</label>
                    <select name="estatus_empleado">
                        <option value="Activo" <?= $empleado['estatus_empleado']=="Activo" ? "selected":"" ?>>Activo</option>
                        <option value="Inactivo" <?= $empleado['estatus_empleado']=="Inactivo" ? "selected":"" ?>>Inactivo</option>
                    </select>
                </div>

            </div>

            <div class="actions">
                <button class="btn btn-primary"><i class="ri-save-line"></i> Guardar cambios</button>
                <a class="btn btn-secondary" href="home.php?page=empleado"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
            </div>

        </form>
    </div>
</div>
