<?php include_once(__DIR__ . "/../../datos/empleadoDatos.php"); ?>

<div class="card">
    <div class="card-header">
        <i class="ri-user-add-line"></i> Nuevo Empleado
    </div>

    <div class="card-body">
        <form action="/ADGAFSI/controles/empleado.php" method="POST">
            <input type="hidden" name="accion" value="agregar">

            <div class="form-grid">

                <div class="form-group">
                    <label>Apellido Paterno *</label>
                    <input type="text" name="apellido_paterno" required>
                </div>

                <div class="form-group">
                    <label>Apellido Materno</label>
                    <input type="text" name="apellido_materno">
                </div>

                <div class="form-group">
                    <label>Nombre *</label>
                    <input type="text" name="nombre_empleado" required>
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="telefono_empleado">
                </div>

                <div class="form-group">
                    <label>Correo</label>
                    <input type="email" name="correo_empleado">
                </div>

                <div class="form-group">
                    <label>Puesto</label>
                    <input type="text" name="puesto">
                </div>

                <div class="form-group">
                    <label>Estatus</label>
                    <select name="estatus_empleado">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>

            </div>

            <div class="actions">
                <button class="btn btn-success">
                    <i class="ri-check-line"></i> Guardar
                </button>

                <a class="btn btn-secondary" href="home.php?page=empleado">
                    <i class="ri-arrow-go-back-line"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
