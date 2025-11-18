<?php
include_once(__DIR__ . "/../../datos/articuloDatos.php");
?>

<div class="card">
  <div class="card-header"><i class="ri-add-circle-line"></i> Nuevo Artículo</div>
  <div class="card-body">

    <form action="controles/articulo.php" method="POST">
        <input type="hidden" name="accion" value="agregar">

        <div class="form-grid">

            <div class="form-group">
                <label>Nombre del Artículo</label>
                <input type="text" name="nombre_articulo" required>
            </div>

            <div class="form-group">
                <label>Tipo</label>
                <input type="text" name="tipo_articulo">
            </div>

            <div class="form-group">
                <label>Marca</label>
                <input type="text" name="marca_articulo">
            </div>

            <div class="form-group full">
                <label>Descripción</label>
                <textarea name="descripcion_articulo" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Precio Unitario</label>
                <input type="text" name="precio_unitario" placeholder="0.00">
            </div>

            <div class="form-group">
                <label>Cantidad Disponible</label>
                <input type="number" name="cantidad_disponible" min="0" value="0">
            </div>

        </div>

        <div class="actions">
            <button class="btn btn-success" type="submit"><i class="ri-check-line"></i> Guardar</button>
            <a href="home.php?page=articulo" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
        </div>

    </form>

  </div>
</div>
