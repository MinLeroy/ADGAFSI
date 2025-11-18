<?php
include_once(__DIR__ . "/../../datos/articuloDatos.php");
$id = intval($_GET['id'] ?? 0);
$art = obtenerArticulo($conn, $id);
?>

<div class="card">
  <div class="card-header"><i class="ri-edit-line"></i> Editar Artículo</div>
  <div class="card-body">

    <form action="/ADGAFSI/controles/articulo.php" method="POST">
        <input type="hidden" name="accion" value="editar">
        <input type="hidden" name="id_articulo" value="<?= $id ?>">

        <div class="form-grid">

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre_articulo" value="<?= htmlspecialchars($art['nombre_articulo']) ?>" required>
            </div>

            <div class="form-group">
                <label>Tipo</label>
                <input type="text" name="tipo_articulo" value="<?= htmlspecialchars($art['tipo_articulo']) ?>">
            </div>

            <div class="form-group">
                <label>Marca</label>
                <input type="text" name="marca_articulo" value="<?= htmlspecialchars($art['marca_articulo']) ?>">
            </div>

            <div class="form-group full">
                <label>Descripción</label>
                <textarea name="descripcion_articulo" rows="3"><?= htmlspecialchars($art['descripcion_articulo']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Precio Unitario</label>
                <input type="text" name="precio_unitario" value="<?= $art['precio_unitario'] ?>">
            </div>

            <div class="form-group">
                <label>Cantidad Disponible</label>
                <input type="number" name="cantidad_disponible" value="<?= $art['cantidad_disponible'] ?>">
            </div>

        </div>

        <div class="actions">
            <button class="btn btn-success" type="submit"><i class="ri-check-line"></i> Actualizar</button>
            <a href="home.php?page=articulo" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
        </div>

    </form>

  </div>
</div>
