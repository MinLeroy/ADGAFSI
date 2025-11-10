<?php
header('Content-Type: application/json');
include_once(__DIR__ . '/../BD/conexion.php');

try {
    $stmt = $conn->query("SELECT * FROM PANEL_GENERAL");
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data ?: []);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
