<?php
include_once("datos/clienteDatos.php");

// obtener listas
$empleados = $conn->query("SELECT id_empleado, nombre_empleado FROM EMPLEADO WHERE estatus_empleado='Activo'")->fetchAll();
$zonas = $conn->query("SELECT id_zona, nombre_zona FROM ZONA")->fetchAll();
?>

<div class="card">
    <div class="card-header">
        <i class="ri-user-add-line"></i> Nuevo Cliente
    </div>

    <div class="card-body">
        <form action="controles/clientes.php" method="POST">
            <input type="hidden" name="accion" value="agregar">

            <div class="form-grid">
                <div class="form-group">
                    <label>Empleado Asignado</label>
                    <select name="id_empleado">
                        <option value="">— Selecciona —</option>
                        <?php foreach ($empleados as $e): ?>
                            <option value="<?= $e['id_empleado'] ?>"><?= $e['nombre_empleado'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Zona</label>
                    <select name="id_zona">
                        <option value="">— Selecciona —</option>
                        <?php foreach ($zonas as $z): ?>
                            <option value="<?= $z['id_zona'] ?>"><?= $z['nombre_zona'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group"><label>Apellido Paterno *</label><input type="text" name="apellido_paterno" required></div>
                <div class="form-group"><label>Apellido Materno</label><input type="text" name="apellido_materno"></div>
                <div class="form-group"><label>Nombre *</label><input type="text" name="nombre_cliente" required></div>
                <div class="form-group"><label>Teléfono 1 *</label><input type="text" name="telefono1" required></div>
                <div class="form-group"><label>Teléfono 2</label><input type="text" name="telefono2"></div>
                <div class="form-group"><label>Correo</label><input type="email" name="correo_cliente"></div>
                <div class="form-group"><label>Calle</label><input type="text" name="calle"></div>
                <div class="form-group"><label>Número</label><input type="text" name="numero"></div>
                <div class="form-group"><label>Colonia</label><input type="text" name="colonia"></div>
                <div class="form-group"><label>Municipio</label><input type="text" name="municipio"></div>
                <div class="form-group"><label>Código Postal</label><input type="text" name="codigo_postal"></div>
                <div class="form-group"><label>Observaciones</label><textarea name="observaciones" rows="3"></textarea></div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-success"><i class="ri-check-line"></i> Guardar</button>
                <a href="home.php?page=cliente" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
