<?php
include_once("datos/clienteDatos.php");
$resumen = resumenClientes($conn);
$clientes = obtenerClientes($conn);
?>

<!-- 🔹 Resumen general -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['activos'] ?? 0 ?></div>
        <div class="stat-label">Clientes Activos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['inactivos'] ?? 0 ?></div>
        <div class="stat-label">Clientes Inactivos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['nuevos_mes'] ?? 0 ?></div>
        <div class="stat-label">Nuevos del Mes</div>
    </div>
</div>

<!-- 🔹 Lista de clientes -->
<div class="card">
    <div class="card-header">
        <i class="ri-user-line"></i> Lista de Clientes
    </div>

    <div class="card-body">
        <div class="actions">
            <a href="home.php?page=cliente/agregar" class="btn btn-primary">
                <i class="ri-user-add-line"></i> Nuevo Cliente
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre completo</th>
                        <th>Teléfono</th>
                        <th>Zona</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($clientes as $c): ?>
                    <tr>
                        <td><?= $c['id_cliente'] ?></td>
                        <td><?= $c['nombre_cliente'] . ' ' . $c['apellido_paterno'] . ' ' . $c['apellido_materno'] ?></td>
                        <td><?= $c['telefono1'] ?></td>
                        <td><?= $c['nombre_zona'] ?? '—' ?></td>
                        <td><?= $c['estatus_cliente'] ?></td>
                        <td>
                            <a href="home.php?page=cliente/ver&id=<?= $c['id_cliente'] ?>" class="btn btn-sm btn-info">
                                <i class="ri-eye-line"></i>
                            </a>
                            <form action="controles/clientes.php" method="POST" style="display:inline;">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id_cliente" value="<?= $c['id_cliente'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar cliente?')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
