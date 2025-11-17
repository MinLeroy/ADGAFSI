<?php include_once(__DIR__ . "/../../datos/zonaDatos.php"); ?>

<div class="card">
    <div class="card-header">
        <i class="ri-add-circle-line"></i> Nueva Zona
    </div>

    <div class="card-body">
        <form action="/ADGAFSI/controles/zona.php" method="POST">
            <input type="hidden" name="accion" value="agregar">

            <div class="form-grid">

                <div class="form-group">
                    <label>Nombre Zona *</label>
                    <input type="text" name="nombre_zona" required>
                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="direccion_zona">
                </div>

                <div class="form-group">
                    <label>Capacidad (Mbps)</label>
                    <input type="number" name="capacidad_megas">
                </div>

                <div class="form-group full-width">
                    <label>Descripción</label>
                    <textarea name="descripcion_zona"></textarea>
                </div>

            </div>

            <div class="actions">
                <button class="btn btn-success"><i class="ri-check-line"></i> Guardar</button>
                <a class="btn btn-secondary" href="home.php?page=zona"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
