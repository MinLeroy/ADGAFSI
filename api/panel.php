<?php
// api/panel.php
header("Content-Type: application/json");
include_once(__DIR__ . "/../BD/conexion.php");

$response = [
    "total_clientes" => 0,
    "total_servicios_activos" => 0,
    "contratos_vigentes" => 0,
    "instalaciones_pendientes" => 0,
    "pagos_proximos" => 0
];

try {
    // Primero intenta leer la vista PANEL_GENERAL (si existe)
    $stmt = $conn->query("SELECT * FROM PANEL_GENERAL");
    $panel = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($panel) {
        $response["total_clientes"] = isset($panel["total_clientes"]) ? (int)$panel["total_clientes"] : 0;
        $response["total_servicios_activos"] = isset($panel["total_servicios_activos"]) ? (int)$panel["total_servicios_activos"] : 0;
        $response["contratos_vigentes"] = isset($panel["contratos_vigentes"]) ? (int)$panel["contratos_vigentes"] : 0;
        $response["instalaciones_pendientes"] = isset($panel["instalaciones_pendientes"]) ? (int)$panel["instalaciones_pendientes"] : 0;
    }

    // PAGOS PRÓXIMOS (modelo B: basado en fecha_proximo_pago)
    // Usamos GETDATE() y DATEADD para SQL Server
    $sql = "SELECT COUNT(*) AS total
            FROM PAGO
            WHERE estatus_pago = 'Pendiente'
              AND fecha_proximo_pago BETWEEN GETDATE() AND DATEADD(DAY, 3, GETDATE())";
    $stmt2 = $conn->query($sql);
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);
    $response['pagos_proximos'] = isset($row['total']) ? (int)$row['total'] : 0;

    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
