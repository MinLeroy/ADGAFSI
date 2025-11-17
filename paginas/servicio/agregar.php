<?php
include_once(__DIR__ . "/../../datos/servicioDatos.php");
?>

<div class="card">
    <div class="card-header">
        <i class="ri-wifi-line"></i> Nuevo Servicio
    </div>

    <div class="card-body">
        <form action="/ADGAFSI/controles/servicio.php" method="POST">
            <input type="hidden" name="accion" value="agregar">

            <div class="form-grid">

                <div class="form-group">
                    <label>Nombre del Servicio *</label>
                    <input type="text" name="nombre_servicio" required>
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
                    <input type="number" name="velocidad_megas" min="1">
                </div>

                <div class="form-group">
                    <label>Costo Primer Mes</label>
                    <input type="number" step="0.01" name="costo_primer_mes">
                </div>

                <div class="form-group">
                    <label>Costo Regular</label>
                    <input type="number" step="0.01" name="costo_regular">
                </div>

                <div class="form-group">
                    <label>Requiere Instalación</label>
                    <select name="requiere_instalacion">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>
                </div>

                <div class="form-group full">
                    <label>Descripción</label>
                    <textarea name="descripcion_servicio" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label>Estado</label>
                    <select name="estado_servicio">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

            </div>

            <div class="actions">
                <button type="submit" class="btn btn-success">
                    <i class="ri-check-line"></i> Guardar
                </button>
                <a href="home.php?page=servicio" class="btn btn-secondary">
                    <i class="ri-arrow-go-back-line"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
