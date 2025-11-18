<?php
// datos/pagoDatos.php
include_once(__DIR__ . '/../BD/conexion.php');

/* Obtener listado de pagos (lista principal mostrará sólo 4 campos) */
function obtenerPagos($conn) {
    $sql = "
      SELECT p.id_pago,
             p.id_contrato,
             p.fecha_proximo_pago,
             p.monto_pago,
             p.estatus_pago,
             -- cliente (desde contrato->cliente)
             cl.id_cliente,
             CONCAT(cl.nombre_cliente, ' ', cl.apellido_paterno, ISNULL(CONCAT(' ', cl.apellido_materno), '')) AS cliente_nombre_completo,
             s.nombre_servicio
      FROM PAGO p
      INNER JOIN CONTRATO c ON p.id_contrato = c.id_contrato
      INNER JOIN CLIENTE cl ON c.id_cliente = cl.id_cliente
      LEFT JOIN SERVICIO s ON c.id_servicio = s.id_servicio
      ORDER BY p.id_pago DESC
    ";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* Obtener pago por id */
function obtenerPagoPorId($conn, $id) {
    $sql = "
      SELECT p.*,
             c.id_contrato,
             c.id_cliente,
             CONCAT(cl.nombre_cliente, ' ', cl.apellido_paterno, ISNULL(CONCAT(' ', cl.apellido_materno), '')) AS cliente_nombre_completo,
             cl.telefono1, cl.telefono2, cl.calle, cl.numero, cl.colonia, cl.municipio, cl.codigo_postal, cl.ip_cliente,
             z.nombre_zona AS zona,
             s.id_servicio, s.nombre_servicio, s.tipo_servicio, s.velocidad_megas,
             CONCAT(e.nombre_empleado, ' ', e.apellido_paterno, ISNULL(CONCAT(' ', e.apellido_materno), '')) AS empleado_nombre_completo
      FROM PAGO p
      INNER JOIN CONTRATO c ON p.id_contrato = c.id_contrato
      INNER JOIN CLIENTE cl ON c.id_cliente = cl.id_cliente
      LEFT JOIN ZONA z ON cl.id_zona = z.id_zona
      LEFT JOIN SERVICIO s ON c.id_servicio = s.id_servicio
      LEFT JOIN EMPLEADO e ON c.id_empleado = e.id_empleado
      WHERE p.id_pago = :id
      ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* Agregar pago */
function agregarPago($conn, $data) {
    $sql = "INSERT INTO PAGO (id_contrato, fecha_pago, monto_pago, id_metodo_pago, ticket_pago, fecha_proximo_pago, estatus_pago)
            VALUES (:id_contrato, :fecha_pago, :monto_pago, :id_metodo_pago, :ticket_pago, :fecha_proximo_pago, :estatus_pago)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id_contrato' => $data['id_contrato'],
        ':fecha_pago' => $data['fecha_pago'] ?? null,
        ':monto_pago' => $data['monto_pago'],
        ':id_metodo_pago' => $data['id_metodo_pago'] ?? null,
        ':ticket_pago' => $data['ticket_pago'] ?? null,
        ':fecha_proximo_pago' => $data['fecha_proximo_pago'] ?? null,
        ':estatus_pago' => $data['estatus_pago'] ?? 'Pendiente'
    ]);
    return $conn->lastInsertId();
}

/* Editar pago */
function editarPago($conn, $id, $data) {
    $sql = "UPDATE PAGO SET id_contrato = :id_contrato, fecha_pago = :fecha_pago, monto_pago = :monto_pago,
            id_metodo_pago = :id_metodo_pago, ticket_pago = :ticket_pago, fecha_proximo_pago = :fecha_proximo_pago,
            estatus_pago = :estatus_pago
            WHERE id_pago = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id_contrato' => $data['id_contrato'],
        ':fecha_pago' => $data['fecha_pago'] ?? null,
        ':monto_pago' => $data['monto_pago'],
        ':id_metodo_pago' => $data['id_metodo_pago'] ?? null,
        ':ticket_pago' => $data['ticket_pago'] ?? null,
        ':fecha_proximo_pago' => $data['fecha_proximo_pago'] ?? null,
        ':estatus_pago' => $data['estatus_pago'] ?? 'Pendiente',
        ':id' => $id
    ]);
}

/* Eliminar pago */
function eliminarPago($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM PAGO WHERE id_pago = :id");
    $stmt->execute([':id' => $id]);
}

/* Contador resumen para pagos (opcional) */
function resumenPagos($conn) {
    $sql = "SELECT 
                (SELECT COUNT(*) FROM PAGO) AS total_pagos,
                (SELECT COUNT(*) FROM PAGO WHERE estatus_pago = 'Pendiente') AS pendientes
            ";
    $stmt = $conn->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
