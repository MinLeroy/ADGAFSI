<?php
include_once(__DIR__ . '/../../BD/conexion.php');

try {
    $sql = "SELECT * FROM PANEL_GENERAL";
    $stmt = $conn->query($sql);
    $panel = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='message error'>Error al obtener datos del panel: " . $e->getMessage() . "</div>";
    $panel = [
        'total_clientes' => 0,
        'total_servicios_activos' => 0,
        'contratos_vigentes' => 0,
        'instalaciones_pendientes' => 0,
        'pagos_proximos' => 0
    ];
}
?>

<!-- 📊 Tarjetas de estadísticas -->
<div class="stats-grid">
    <div class="stat-card">
        <div id="total_clientes" class="stat-value"><?= $panel['total_clientes'] ?? 0 ?></div>
        <div class="stat-label">Clientes Registrados</div>
        <i class="ri-user-line" style="font-size:1.8rem; color:#00bcd4;"></i>
    </div>

    <div class="stat-card">
        <div id="total_servicios_activos" class="stat-value"><?= $panel['total_servicios_activos'] ?? 0 ?></div>
        <div class="stat-label">Servicios Activos</div>
        <i class="ri-wifi-line" style="font-size:1.8rem; color:#00bcd4;"></i>
    </div>

    <div class="stat-card">
        <div id="contratos_vigentes" class="stat-value"><?= $panel['contratos_vigentes'] ?? 0 ?></div>
        <div class="stat-label">Contratos Vigentes</div>
        <i class="ri-file-list-3-line" style="font-size:1.8rem; color:#00bcd4;"></i>
    </div>

    <div class="stat-card">
        <div id="instalaciones_pendientes" class="stat-value"><?= $panel['instalaciones_pendientes'] ?? 0 ?></div>
        <div class="stat-label">Instalaciones Pendientes</div>
        <i class="ri-router-line" style="font-size:1.8rem; color:#00bcd4;"></i>
    </div>

    <div class="stat-card">
        <div id="pagos_proximos" class="stat-value"><?= $panel['pagos_proximos'] ?? 0 ?></div>
        <div class="stat-label">Pagos Próximos (3 días)</div>
        <i class="ri-money-dollar-circle-line" style="font-size:1.8rem; color:#00bcd4;"></i>
    </div>
</div>

<div class="card">
    <div class="card-header">Resumen General</div>
    <div class="card-body">
        <p>Este panel muestra los datos más relevantes del sistema en tiempo real:</p>
        <ul style="margin-top:10px; line-height:1.8;">
            <li>📡 <strong>Clientes</strong>: total de usuarios registrados en el sistema.</li>
            <li>💾 <strong>Servicios activos</strong>: planes actualmente disponibles o activos.</li>
            <li>📄 <strong>Contratos</strong>: número de contratos con estatus "Activo".</li>
            <li>🔧 <strong>Instalaciones pendientes</strong>: instalaciones aún no realizadas.</li>
            <li>💰 <strong>Pagos próximos</strong>: clientes con pagos dentro de los próximos 3 días.</li>
        </ul>
    </div>
</div>

<script src="visual/js/panel.js"></script>
