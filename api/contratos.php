<?php
// /api/contrato.php
header('Content-Type: application/json');
require_once __DIR__ . '/../BD/conexion.php';

$id = $_GET['id'] ?? null;
if (!$id) { echo json_encode(['error' => 'missing id']); exit; }

try {
    $sql = "SELECT c.id_contrato, c.id_cliente, c.id_servicio, c.fecha_contrato,
                   cl.nombre_cliente, cl.apellido_paterno, cl.apellido_materno,
                   cl.telefono1, cl.telefono2, cl.calle, cl.numero, cl.colonia, cl.municipio, cl.codigo_postal, cl.ip_cliente,
                   z.nombre_zona,
                   s.nombre_servicio, s.tipo_servicio, s.velocidad_megas, s.costo_primer_mes, s.costo_regular
            FROM CONTRATO c
            JOIN CLIENTE cl ON cl.id_cliente = c.id_cliente
            LEFT JOIN ZONA z ON cl.id_zona = z.id_zona
            JOIN SERVICIO s ON s.id_servicio = c.id_servicio
            WHERE c.id_contrato = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row ?: []);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
