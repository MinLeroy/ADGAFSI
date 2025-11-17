<?php
// paginas/contrato/editar.php
include_once(__DIR__ . "/../../datos/contratoDatos.php");
$id = $_GET['id'] ?? null;
if (!$id) { echo "<div class='message error'>No especificado.</div>"; exit; }
$ct = obtenerContratoPorId($conn, $id);
if (!$ct) { echo "<div class='message error'>No encontrado.</div>"; exit; }

$clientes = $conn->query("SELECT id_cliente, nombre_cliente, apellido_paterno FROM CLIENTE")->fetchAll(PDO::FETCH_ASSOC);
$servicios = $conn->query("SELECT id_servicio, nombre_servicio FROM SERVICIO WHERE estado_servicio=1")->fetchAll(PDO::FETCH_ASSOC);
$empleados = $conn->query("SELECT id_empleado, nombre_empleado, apellido_paterno FROM EMPLEADO WHERE estatus_empleado='Activo'")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
    <div class="card-header"><i class="ri-edit-2-line"></i> Editar Contrato #<?= $ct['id_contrato'] ?></div>
    <div class="card-body">
        <form action="/ADGAFSI/controles/contrato.php" method="POST">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id_contrato" value="<?= $ct['id_contrato'] ?>">

            <div class="form-grid">
                <div class="form-group">
                    <label>Cliente</label>
                    <select name="id_cliente" required>
                        <?php foreach ($clientes as $c): ?>
                            <option value="<?= $c['id_cliente'] ?>" <?= ($ct['id_cliente'] == $c['id_cliente']) ? 'selected' : '' ?>><?= htmlspecialchars($c['nombre_cliente'].' '.$c['apellido_paterno']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Servicio</label>
                    <select name="id_servicio" required>
                        <?php foreach ($servicios as $s): ?>
                            <option value="<?= $s['id_servicio'] ?>" <?= ($ct['id_servicio'] == $s['id_servicio']) ? 'selected' : '' ?>><?= htmlspecialchars($s['nombre_servicio']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Empleado</label>
                    <select name="id_empleado">
                        <option value="">— Ninguno —</option>
                        <?php foreach ($empleados as $e): ?>
                            <option value="<?= $e['id_empleado'] ?>" <?= ($ct['id_empleado'] == $e['id_empleado']) ? 'selected' : '' ?>><?= htmlspecialchars($e['nombre_empleado'].' '.$e['apellido_paterno']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fecha contrato</label>
                    <input type="datetime-local" name="fecha_contrato" value="<?= $ct['fecha_contrato'] ? date('Y-m-d\TH:i', strtotime($ct['fecha_contrato'])) : '' ?>">
                </div>

                <div class="form-group">
                    <label>Estatus</label>
                    <select name="estatus_contrato" required>
                        <option value="Activo" <?= ($ct['estatus_contrato']=='Activo')?'selected':'' ?>>Activo</option>
                        <option value="Suspendido" <?= ($ct['estatus_contrato']=='Suspendido')?'selected':'' ?>>Suspendido</option>
                        <option value="Cancelado" <?= ($ct['estatus_contrato']=='Cancelado')?'selected':'' ?>>Cancelado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Estado instalación</label>
                    <select name="estado_instalacion" required>
                        <option value="Pendiente" <?= ($ct['estado_instalacion']=='Pendiente')?'selected':'' ?>>Pendiente</option>
                        <option value="Instalado" <?= ($ct['estado_instalacion']=='Instalado')?'selected':'' ?>>Instalado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Monto Total</label>
                    <input type="number" step="0.01" name="monto_total" value="<?= htmlspecialchars($ct['monto_total'] ?? 0) ?>">
                </div>

                <div class="form-group full">
                    <label>Observaciones</label>
                    <textarea name="observaciones" rows="3"><?= htmlspecialchars($ct['observaciones'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-primary" type="submit"><i class="ri-save-3-line"></i> Guardar Cambios</button>
                <a href="home.php?page=contrato" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
