<?php
include_once(__DIR__ . "/../../datos/empleadoDatos.php");

$id = $_GET['id'] ?? null;
$empleado = obtenerEmpleadoPorId($conn, $id);
?>

<div class="card">
    <div class="card-header">
        <i class="ri-user-line"></i> Detalles del Empleado
    </div>

    <div class="card-body">
        <div class="client-details-grid">

            <div class="detail-item"><strong>ID:</strong> <?= $empleado['id_empleado'] ?></div>

            <div class="detail-item">
                <strong>Nombre:</strong>
                <?= htmlspecialchars($empleado['nombre_empleado'] . ' ' . $empleado['apellido_paterno'] . ' ' . $empleado['apellido_materno']) ?>
            </div>

            <div class="detail-item"><strong>Teléfono:</strong> <?= htmlspecialchars($empleado['telefono_empleado'] ?? '—') ?></div>
            <div class="detail-item"><strong>Correo:</strong> <?= htmlspecialchars($empleado['correo_empleado'] ?? '—') ?></div>
            <div class="detail-item"><strong>Puesto:</strong> <?= htmlspecialchars($empleado['puesto'] ?? '—') ?></div>
            <div class="detail-item"><strong>Estatus:</strong> <?= htmlspecialchars($empleado['estatus_empleado'] ?? '—') ?></div>

            <div class="detail-item full-width">
                <strong>Fecha registro:</strong> 
                <?= $empleado['fecha_registro_empleado'] ? date("d/m/Y H:i", strtotime($empleado['fecha_registro_empleado'])) : "—" ?>
            </div>

        </div>

        <div class="actions">
            <a class="btn btn-warning" href="home.php?page=empleado/editar&id=<?= $empleado['id_empleado'] ?>">
                <i class="ri-edit-line"></i> Editar
            </a>
            <a class="btn btn-secondary" href="home.php?page=empleado">
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
</style>
