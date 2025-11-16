<?php
include_once(__DIR__ . "/../../datos/clienteDatos.php");

// Obtener listas desde la conexión
$empleados = $conn->query("
    SELECT id_empleado, 
           CONCAT(nombre_empleado, ' ', apellido_paterno, ' ', COALESCE(apellido_materno, '')) AS nombre_empleado
    FROM EMPLEADO 
    WHERE estatus_empleado = 'Activo'
    ORDER BY nombre_empleado
")->fetchAll(PDO::FETCH_ASSOC);

$zonas = $conn->query("
    SELECT id_zona, nombre_zona 
    FROM ZONA 
    ORDER BY nombre_zona
")->fetchAll(PDO::FETCH_ASSOC);

// servicios desde modelo
$servicios = obtenerServicios($conn);
?>

<div class="card">
    <div class="card-header">
        <i class="ri-user-add-line"></i> Nuevo Cliente
    </div>

    <div class="card-body">
      <form action="/ADGAFSI/controles/cliente.php" method="POST">
            <input type="hidden" name="accion" value="agregar">

            <div class="form-grid">

                <!-- Empleado -->
                <div class="form-group">
                    <label>Empleado Asignado</label>
                    <select name="id_empleado">
                        <option value="">— Selecciona —</option>
                        <?php foreach ($empleados as $e): ?>
                            <option value="<?= $e['id_empleado'] ?>">
                                <?= htmlspecialchars($e['nombre_empleado']) ?>
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
                            <option value="<?= $z['id_zona'] ?>">
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
                            <option value="<?= $s['id_servicio'] ?>">
                                <?= htmlspecialchars($s['nombre_servicio'] . ' (' . $s['tipo_servicio'] . ' - ' . $s['velocidad_megas'] . ' Mbps)') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- IP -->
                <div class="form-group">
                    <label>IP del Cliente</label>
                    <input type="text" name="ip_cliente" placeholder="Ej: 192.168.1.100 o IPv6">
                </div>

                <!-- Datos personales -->
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
                    <input type="text" name="nombre_cliente" required>
                </div>

                <!-- Contacto -->
                <div class="form-group">
                    <label>Teléfono 1 *</label>
                    <input type="text" name="telefono1" required>
                </div>

                <div class="form-group">
                    <label>Teléfono 2</label>
                    <input type="text" name="telefono2">
                </div>

                <div class="form-group">
                    <label>Correo</label>
                    <input type="email" name="correo_cliente">
                </div>

                <!-- Domicilio -->
                <div class="form-group">
                    <label>Calle</label>
                    <input type="text" name="calle">
                </div>

                <div class="form-group">
                    <label>Número</label>
                    <input type="text" name="numero">
                </div>

                <div class="form-group">
                    <label>Colonia</label>
                    <input type="text" name="colonia">
                </div>

                <div class="form-group">
                    <label>Municipio</label>
                    <input type="text" name="municipio">
                </div>

                <div class="form-group">
                    <label>Código Postal</label>
                    <input type="text" name="codigo_postal">
                </div>

                <!-- Estatus -->
                <div class="form-group">
                    <label>Estatus</label>
                    <select name="id_estatus" required>
                    <option value="1" selected>Activo</option>
                    <option value="2">Inactivo</option>
                  </select>
                </div>

                <!-- Observaciones -->
                <div class="form-group full">
                    <label>Observaciones</label>
                    <textarea name="observaciones" rows="3"></textarea>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-success">
                    <i class="ri-check-line"></i> Guardar
                </button>
                <a href="home.php?page=cliente" class="btn btn-secondary">
                    <i class="ri-arrow-go-back-line"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
