<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../BD/conexion.php';

$id = $_GET['id'] ?? null;
if (!$id) { echo json_encode(['error' => 'missing id']); exit; }

$sql = "SELECT p.*, 
        CONCAT(c.nombre_cliente,' ',c.apellido_paterno,' ',c.apellido_materno) AS cliente,
        m.nombre_metodo
        FROM PAGO p
        JOIN CONTRATO ct ON ct.id_contrato = p.id_contrato
        JOIN CLIENTE c ON c.id_cliente = ct.id_cliente
        JOIN CAT_METODO_PAGO m ON m.id_metodo_pago = p.id_metodo_pago
        WHERE p.id_pago = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
