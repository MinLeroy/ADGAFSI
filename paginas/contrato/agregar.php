<?php
// paginas/contrato/agregar.php
include_once(__DIR__ . "/../../datos/contratoDatos.php");

// listas
$clientes = $conn->query("SELECT id_cliente, nombre_cliente, apellido_paterno, apellido_materno FROM CLIENTE ORDER BY id_cliente DESC")->fetchAll(PDO::FETCH_ASSOC);
$servicios = $conn->query("SELECT id_servicio, nombre_servicio FROM SERVICIO WHERE estado_servicio=1 ORDER BY nombre_servicio")->fetchAll(PDO::FETCH_ASSOC);
$empleados = $conn->query("SELECT id_empleado, nombre_empleado, apellido_paterno, apellido_materno FROM EMPLEADO WHERE estatus_empleado='Activo'")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
    <div class="card-header"><i class="ri-add-circle-line"></i> Nuevo Contrato</div>
    <div class="card-body">
        <form action="/ADGAFSI/controles/contrato.php" method="POST">
            <input type="hidden" name="accion" value="agregar">
            <div class="form-grid">
                <div class="form-group">
                    <label>Cliente</label>
                    <select name="id_cliente" required>
                        <option value="">— Selecciona —</option>
                        <?php foreach ($clientes as $c): ?>
                            <option value="<?= $c['id_cliente'] ?>"><?= htmlspecialchars($c['nombre_cliente'].' '.$c['apellido_paterno']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Servicio</label>
                    <select name="id_servicio" required>
                        <option value="">— Selecciona —</option>
                        <?php foreach ($servicios as $s): ?>
                            <option value="<?= $s['id_servicio'] ?>"><?= htmlspecialchars($s['nombre_servicio']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Empleado (vendedor)</label>
                    <select name="id_empleado">
                        <option value="">— Ninguno —</option>
                        <?php foreach ($empleados as $e): ?>
                            <option value="<?= $e['id_empleado'] ?>"><?= htmlspecialchars($e['nombre_empleado'].' '.$e['apellido_paterno']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fecha contrato</label>
                    <input type="datetime-local" name="fecha_contrato">
                </div>

                <div class="form-group">
                    <label>Estatus</label>
                    <select name="estatus_contrato" required>
                        <option value="Activo" selected>Activo</option>
                        <option value="Suspendido">Suspendido</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Estado instalación</label>
                    <select name="estado_instalacion" required>
                        <option value="Pendiente" selected>Pendiente</option>
                        <option value="Instalado">Instalado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Monto Total</label>
                    <input type="number" step="0.01" name="monto_total" value="0">
                </div>

                <div class="form-group full">
                    <label>Observaciones</label>
                    <textarea name="observaciones" rows="3"></textarea>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-success" type="submit"><i class="ri-check-line"></i> Guardar</button>
                <a href="home.php?page=contrato" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
