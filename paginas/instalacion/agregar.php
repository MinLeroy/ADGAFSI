<?php
// paginas/instalacion/agregar.php
include_once(__DIR__ . "/../../datos/instalacionDatos.php");

// Listas
// Solo mostrar contratos que tengan estado_instalacion = 'Pendiente' o servicios que requieran instalacion
$contratos = $conn->query("
    SELECT c.id_contrato, cl.nombre_cliente, cl.apellido_paterno, cl.apellido_materno, s.nombre_servicio
    FROM CONTRATO c
    INNER JOIN CLIENTE cl ON c.id_cliente = cl.id_cliente
    INNER JOIN SERVICIO s ON c.id_servicio = s.id_servicio
    WHERE c.estado_instalacion = 'Pendiente' OR s.requiere_instalacion = 1
    ORDER BY c.id_contrato DESC
")->fetchAll(PDO::FETCH_ASSOC);

$tecnicos = $conn->query("SELECT id_empleado, nombre_empleado, apellido_paterno, apellido_materno FROM EMPLEADO WHERE estatus_empleado = 'Activo' ORDER BY nombre_empleado")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
    <div class="card-header"><i class="ri-add-circle-line"></i> Nueva Instalación</div>
    <div class="card-body">
        <form action="/ADGAFSI/controles/instalacion.php" method="POST">
            <input type="hidden" name="accion" value="agregar">
            <div class="form-grid">
                <div class="form-group">
                    <label>Contrato</label>
                    <select name="id_contrato" required>
                        <option value="">— Selecciona —</option>
                        <?php foreach ($contratos as $c): ?>
                            <?php $nombre = htmlspecialchars($c['nombre_cliente'].' '.$c['apellido_paterno'].' - '.$c['nombre_servicio']); ?>
                            <option value="<?= $c['id_contrato'] ?>"><?= $nombre ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Técnico asignado</label>
                    <select name="tecnico_asignado">
                        <option value="">— Ninguno —</option>
                        <?php foreach ($tecnicos as $t): ?>
                            <option value="<?= $t['id_empleado'] ?>"><?= htmlspecialchars($t['nombre_empleado'].' '.$t['apellido_paterno']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fecha programada</label>
                    <input type="datetime-local" name="fecha_programada">
                </div>

                <div class="form-group">
                    <label>Fecha realizada</label>
                    <input type="datetime-local" name="fecha_realizada">
                </div>

                <div class="form-group">
                    <label>Estatus</label>
                    <select name="estatus_instalacion" required>
                        <option value="Pendiente" selected>Pendiente</option>
                        <option value="Programada">Programada</option>
                        <option value="Realizada">Realizada</option>
                        <option value="Cancelada">Cancelada</option>
                    </select>
                </div>

                <div class="form-group full">
                    <label>Comentarios</label>
                    <textarea name="comentarios" rows="3"></textarea>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-success" type="submit"><i class="ri-check-line"></i> Guardar</button>
                <a href="home.php?page=instalacion" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
