<?php
// paginas/instalacion/editar.php
include_once(__DIR__ . "/../../datos/instalacionDatos.php");
$id = $_GET['id'] ?? null;
if (!$id) { echo "<div class='message error'>No especificado.</div>"; exit; }
$it = obtenerInstalacionPorId($conn, $id);
if (!$it) { echo "<div class='message error'>No encontrado.</div>"; exit; }

$contratos = $conn->query("SELECT id_contrato FROM CONTRATO ORDER BY id_contrato DESC")->fetchAll(PDO::FETCH_ASSOC);
$tecnicos = $conn->query("SELECT id_empleado, nombre_empleado, apellido_paterno FROM EMPLEADO WHERE estatus_empleado='Activo'")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
    <div class="card-header"><i class="ri-edit-2-line"></i> Editar Instalación #<?= $it['id_instalacion'] ?></div>
    <div class="card-body">
        <form action="/ADGAFSI/controles/instalacion.php" method="POST">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id_instalacion" value="<?= $it['id_instalacion'] ?>">

            <div class="form-grid">
                <div class="form-group">
                    <label>Contrato</label>
                    <select name="id_contrato" required>
                        <?php foreach ($contratos as $c): ?>
                            <option value="<?= $c['id_contrato'] ?>" <?= ($it['id_contrato'] == $c['id_contrato']) ? 'selected' : '' ?>>Contrato #<?= $c['id_contrato'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Técnico asignado</label>
                    <select name="tecnico_asignado">
                        <option value="">— Ninguno —</option>
                        <?php foreach ($tecnicos as $t): ?>
                            <option value="<?= $t['id_empleado'] ?>" <?= ($it['tecnico_asignado'] == $t['id_empleado']) ? 'selected' : '' ?>><?= htmlspecialchars($t['nombre_empleado'].' '.$t['apellido_paterno']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fecha programada</label>
                    <input type="datetime-local" name="fecha_programada" value="<?= $it['fecha_programada'] ? date('Y-m-d\TH:i', strtotime($it['fecha_programada'])) : '' ?>">
                </div>

                <div class="form-group">
                    <label>Fecha realizada</label>
                    <input type="datetime-local" name="fecha_realizada" value="<?= $it['fecha_realizada'] ? date('Y-m-d\TH:i', strtotime($it['fecha_realizada'])) : '' ?>">
                </div>

                <div class="form-group">
                    <label>Estatus</label>
                    <select name="estatus_instalacion" required>
                        <option value="Pendiente" <?= ($it['estatus_instalacion']=='Pendiente')?'selected':'' ?>>Pendiente</option>
                        <option value="Programada" <?= ($it['estatus_instalacion']=='Programada')?'selected':'' ?>>Programada</option>
                        <option value="Realizada" <?= ($it['estatus_instalacion']=='Realizada')?'selected':'' ?>>Realizada</option>
                        <option value="Cancelada" <?= ($it['estatus_instalacion']=='Cancelada')?'selected':'' ?>>Cancelada</option>
                    </select>
                </div>

                <div class="form-group full">
                    <label>Comentarios</label>
                    <textarea name="comentarios" rows="3"><?= htmlspecialchars($it['comentarios'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-primary" type="submit"><i class="ri-save-3-line"></i> Guardar Cambios</button>
                <a href="home.php?page=instalacion" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
