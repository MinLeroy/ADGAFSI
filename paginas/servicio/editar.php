<?php
include_once(__DIR__ . "/../../datos/servicioDatos.php");

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<div class='message error'>No se especificó servicio.</div>";
    exit;
}

$servicio = obtenerServicioPorId($conn, $id);
if (!$servicio) {
    echo "<div class='message error'>Servicio no encontrado.</div>";
    exit;
}
?>

<div class="card">
    <div class="card-header">
        <i class="ri-edit-2-line"></i> Editar Servicio
    </div>

    <div class="card-body">
        <form action="/ADGAFSI/controles/servicio.php" method="POST">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id_servicio" value="<?= $servicio['id_servicio'] ?>">

            <div class="form-grid">

                <div class="form-group">
                    <label>Nombre *</label>
                    <input type="text" name="nombre_servicio"
                           value="<?= htmlspecialchars($servicio['nombre_servicio']) ?>" required>
                </div>

                <div class="form-group">
                     <label>Tipo de Servicio *</label>
                     <select name="tipo_servicio" required>
                            <option value="">— Selecciona —</option>
                            <option value="Antena">Antena</option>
                            <option value="Fibra Óptica">Fibra Óptica</option>
                     </select>
                     </div>

                <div class="form-group">
                    <label>Velocidad (Mbps)</label>
                    <input type="number" name="velocidad_megas"
                           value="<?= htmlspecialchars($servicio['velocidad_megas']) ?>">
                </div>

                <div class="form-group">
                    <label>Costo Primer Mes</label>
                    <input type="number" step="0.01" name="costo_primer_mes"
                           value="<?= htmlspecialchars($servicio['costo_primer_mes']) ?>">
                </div>

                <div class="form-group">
                    <label>Costo Regular</label>
                    <input type="number" step="0.01" name="costo_regular"
                           value="<?= htmlspecialchars($servicio['costo_regular']) ?>">
                </div>

                <div class="form-group">
                    <label>Requiere instalación</label>
                    <select name="requiere_instalacion">
                        <option value="0" <?= !$servicio['requiere_instalacion'] ? 'selected' : '' ?>>No</option>
                        <option value="1" <?= $servicio['requiere_instalacion'] ? 'selected' : '' ?>>Sí</option>
                    </select>
                </div>

                <div class="form-group full">
                    <label>Descripción</label>
                    <textarea name="descripcion_servicio" rows="3"><?= htmlspecialchars($servicio['descripcion_servicio']) ?></textarea>
                </div>

                <div class="form-group">
                    <label>Estado</label>
                    <select name="estado_servicio">
                        <option value="1" <?= $servicio['estado_servicio'] ? 'selected' : '' ?>>Activo</option>
                        <option value="0" <?= !$servicio['estado_servicio'] ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>

            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i> Guardar Cambios
                </button>

                <a href="home.php?page=servicio" class="btn btn-secondary">
                    <i class="ri-arrow-go-back-line"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
