<?php
include_once("datos/clienteDatos.php");

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<div class='message error'>No se especificó cliente.</div>";
    exit;
}

$cliente = obtenerClientePorId($conn, $id);
if (!$cliente) {
    echo "<div class='message error'>Cliente no encontrado.</div>";
    exit;
}

// Listas para selects
$empleados = $conn->query("SELECT id_empleado, nombre_empleado FROM EMPLEADO WHERE estatus_empleado='Activo'")->fetchAll();
$zonas = $conn->query("SELECT id_zona, nombre_zona FROM ZONA")->fetchAll();
?>

<div class="card">
    <div class="card-header">
        <i class="ri-edit-2-line"></i> Editar Cliente
    </div>

    <div class="card-body">
        <form action="controles/clientes.php" method="POST">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">

            <div class="form-grid">
                <!-- Empleado -->
                <div class="form-group">
                    <label>Empleado Asignado</label>
                    <select name="id_empleado">
                        <option value="">— Selecciona —</option>
                        <?php foreach ($empleados as $e): ?>
                            <option value="<?= $e['id_empleado'] ?>" <?= ($cliente['id_empleado'] == $e['id_empleado']) ? 'selected' : '' ?>>
                                <?= $e['nombre_empleado'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Zona -->
                <div class="form-group">
                    <label>Zona</label>
                    <select name="id_zona">
                        <option value="">— Selecciona —</option>
                        <?php foreach ($zonas as $z): ?>
                            <option value="<?= $z['id_zona'] ?>" <?= ($cliente['id_zona'] == $z['id_zona']) ? 'selected' : '' ?>>
                                <?= $z['nombre_zona'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group"><label>Apellido Paterno *</label><input type="text" name="apellido_paterno" value="<?= $cliente['apellido_paterno'] ?>" required></div>
                <div class="form-group"><label>Apellido Materno</label><input type="text" name="apellido_materno" value="<?= $cliente['apellido_materno'] ?>"></div>
                <div class="form-group"><label>Nombre *</label><input type="text" name="nombre_cliente" value="<?= $cliente['nombre_cliente'] ?>" required></div>
                <div class="form-group"><label>Teléfono 1 *</label><input type="text" name="telefono1" value="<?= $cliente['telefono1'] ?>" required></div>
                <div class="form-group"><label>Teléfono 2</label><input type="text" name="telefono2" value="<?= $cliente['telefono2'] ?>"></div>
                <div class="form-group"><label>Correo</label><input type="email" name="correo_cliente" value="<?= $cliente['correo_cliente'] ?>"></div>
                <div class="form-group"><label>Calle</label><input type="text" name="calle" value="<?= $cliente['calle'] ?>"></div>
                <div class="form-group"><label>Número</label><input type="text" name="numero" value="<?= $cliente['numero'] ?>"></div>
                <div class="form-group"><label>Colonia</label><input type="text" name="colonia" value="<?= $cliente['colonia'] ?>"></div>
                <div class="form-group"><label>Municipio</label><input type="text" name="municipio" value="<?= $cliente['municipio'] ?>"></div>
                <div class="form-group"><label>Código Postal</label><input type="text" name="codigo_postal" value="<?= $cliente['codigo_postal'] ?>"></div>
                <div class="form-group"><label>Observaciones</label><textarea name="observaciones" rows="3"><?= $cliente['observaciones'] ?></textarea></div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary"><i class="ri-save-3-line"></i> Guardar Cambios</button>
                <a href="home.php?page=cliente" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
