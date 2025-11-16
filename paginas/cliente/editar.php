<?php
include_once(__DIR__ . "/../../datos/clienteDatos.php");

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
$empleados = $conn->query("SELECT id_empleado, nombre_empleado, apellido_paterno, apellido_materno FROM EMPLEADO WHERE estatus_empleado='Activo'")->fetchAll(PDO::FETCH_ASSOC);
$zonas = $conn->query("SELECT id_zona, nombre_zona FROM ZONA")->fetchAll(PDO::FETCH_ASSOC);
$servicios = obtenerServicios($conn);
?>

<div class="card">
    <div class="card-header">
        <i class="ri-edit-2-line"></i> Editar Cliente
    </div>

    <div class="card-body">
        <form action="/ADGAFSI/controles/cliente.php" method="POST">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">

            <div class="form-grid">
                <!-- Empleado -->
                <div class="form-group">
                    <label>Empleado Asignado</label>
                    <select name="id_empleado">
                        <option value="">— Selecciona —</option>
                        <?php foreach ($empleados as $e): ?>
                            <?php 
                                $nombreEmp = trim($e['nombre_empleado'] . ' ' . $e['apellido_paterno'] . ' ' . ($e['apellido_materno'] ?? ''));
                            ?>
                            <option value="<?= $e['id_empleado'] ?>" <?= ($cliente['id_empleado'] == $e['id_empleado']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($nombreEmp) ?>
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
                                <?= htmlspecialchars($z['nombre_zona']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Servicio -->
                <div class="form-group">
                    <label>Servicio</label>
                    <select name="id_servicio" required>
                        <option value="">— Selecciona servicio —</option>
                        <?php foreach ($servicios as $s): ?>
                            <option value="<?= $s['id_servicio'] ?>" <?= ($cliente['id_servicio'] == $s['id_servicio']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['nombre_servicio'] . ' (' . $s['tipo_servicio'] . ' - ' . $s['velocidad_megas'] . ' Mbps)') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- IP -->
                <div class="form-group">
                    <label>IP del Cliente</label>
                    <input type="text" name="ip_cliente" value="<?= htmlspecialchars($cliente['ip_cliente'] ?? '') ?>">
                </div>

                <div class="form-group"><label>Apellido Paterno *</label><input type="text" name="apellido_paterno" value="<?= htmlspecialchars($cliente['apellido_paterno']) ?>" required></div>
                <div class="form-group"><label>Apellido Materno</label><input type="text" name="apellido_materno" value="<?= htmlspecialchars($cliente['apellido_materno']) ?>"></div>
                <div class="form-group"><label>Nombre *</label><input type="text" name="nombre_cliente" value="<?= htmlspecialchars($cliente['nombre_cliente']) ?>" required></div>
                <div class="form-group"><label>Teléfono 1 *</label><input type="text" name="telefono1" value="<?= htmlspecialchars($cliente['telefono1']) ?>" required></div>
                <div class="form-group"><label>Teléfono 2</label><input type="text" name="telefono2" value="<?= htmlspecialchars($cliente['telefono2']) ?>"></div>
                <div class="form-group"><label>Correo</label><input type="email" name="correo_cliente" value="<?= htmlspecialchars($cliente['correo_cliente']) ?>"></div>
                <div class="form-group"><label>Calle</label><input type="text" name="calle" value="<?= htmlspecialchars($cliente['calle']) ?>"></div>
                <div class="form-group"><label>Número</label><input type="text" name="numero" value="<?= htmlspecialchars($cliente['numero']) ?>"></div>
                <div class="form-group"><label>Colonia</label><input type="text" name="colonia" value="<?= htmlspecialchars($cliente['colonia']) ?>"></div>
                <div class="form-group"><label>Municipio</label><input type="text" name="municipio" value="<?= htmlspecialchars($cliente['municipio']) ?>"></div>
                <div class="form-group"><label>Código Postal</label><input type="text" name="codigo_postal" value="<?= htmlspecialchars($cliente['codigo_postal']) ?>"></div>
                <div class="form-group"><label>Observaciones</label><textarea name="observaciones" rows="3"><?= htmlspecialchars($cliente['observaciones']) ?></textarea></div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary"><i class="ri-save-3-line"></i> Guardar Cambios</button>
                <a href="home.php?page=cliente" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
