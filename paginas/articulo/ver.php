<?php
// paginas/articulo/ver.php
include_once(__DIR__ . "/../../datos/articuloDatos.php");

$id = $_GET['id'] ?? null;
if (!$id) { 
    echo "<div class='message error'>Artículo no especificado.</div>"; 
    exit; 
}

$art = obtenerArticulo($conn, $id);

if (!$art) { 
    echo "<div class='message error'>Artículo no encontrado.</div>"; 
    exit; 
}
?>

<div class="card">
    <div class="card-header">
        <i class="ri-archive-line"></i> Detalles del Artículo
    </div>

    <div class="card-body">
        <div class="client-details-grid">

            <div class="detail-item">
                <strong>Nombre:</strong> <?= htmlspecialchars($art['nombre_articulo']) ?>
            </div>

            <div class="detail-item">
                <strong>Tipo:</strong> <?= htmlspecialchars($art['tipo_articulo']) ?>
            </div>

            <div class="detail-item">
                <strong>Marca:</strong> <?= htmlspecialchars($art['marca_articulo']) ?>
            </div>

            <div class="detail-item">
                <strong>Precio Unitario:</strong> $<?= number_format($art['precio_unitario'], 2) ?>
            </div>

            <div class="detail-item">
                <strong>Cantidad Disponible:</strong> <?= htmlspecialchars($art['cantidad_disponible']) ?>
            </div>

            <div class="detail-item full-width">
                <strong>Descripción:</strong><br>
                <?= nl2br(htmlspecialchars($art['descripcion_articulo'])) ?>
            </div>
        </div>

        <div class="actions">
            <a href="home.php?page=articulo_edit&id=<?= $art['id_articulo'] ?>" class="btn btn-warning">
                <i class="ri-edit-line"></i> Editar
            </a>

            <a href="home.php?page=articulo" class="btn btn-secondary">
                <i class="ri-arrow-go-back-line"></i> Volver
            </a>
        </div>
    </div>
</div>

<style>
.client-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}
.detail-item {
    background: #0f0f0f;
    padding: 12px 14px;
    border-radius: 8px;
    color: #ddd;
    box-shadow: 0 2px 6px rgba(0,0,0,0.4);
}
.detail-item.full-width {
    grid-column: 1 / -1;
}
.actions { 
    text-align: right; 
}
</style>
