<?php
include_once(__DIR__ . "/../../datos/zonaDatos.php");

$id = $_GET['id'] ?? null;
$zona = obtenerZonaPorId($conn, $id);
?>

<div class="card">
    <div class="card-header">
        <i class="ri-edit-line"></i> Editar Zona
    </div>

    <div class="card-body">
        <form action="/ADGAFSI/controles/zona.php" method="POST">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id_zona" value="<?= $zona['id_zona'] ?>">

            <div class="form-grid">

                <div class="form-group">
                    <label>Nombre Zona *</label>
                    <input type="text" name="nombre_zona" value="<?= $zona['nombre_zona'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="direccion_zona" value="<?= $zona['direccion_zona'] ?>">
                </div>

                <div class="form-group">
                    <label>Capacidad (Mbps)</label>
                    <input type="number" name="capacidad_megas" value="<?= $zona['capacidad_megas'] ?>">
                </div>

                <div class="form-group full-width">
                    <label>Descripción</label>
                    <textarea name="descripcion_zona"><?= htmlspecialchars($zona['descripcion_zona']) ?></textarea>
                </div>

            </div>

            <div class="actions">
                <button class="btn btn-primary"><i class="ri-save-line"></i> Guardar cambios</button>
                <a class="btn btn-secondary" href="home.php?page=zona"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
            </div>

        </form>
    </div>
</div>
