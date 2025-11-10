<?php
include_once(__DIR__ . '/../BD/conexion.php');

/* 🔹 Resumen de clientes */
function resumenClientes($conn) {
    $sql = "
        SELECT 
            (SELECT COUNT(*) FROM CLIENTE WHERE id_estatus = 1) AS activos,
            (SELECT COUNT(*) FROM CLIENTE WHERE id_estatus = 2) AS inactivos,
            (SELECT COUNT(*) FROM CLIENTE 
                WHERE MONTH(fecha_registro_cliente) = MONTH(GETDATE())
                AND YEAR(fecha_registro_cliente) = YEAR(GETDATE())) AS nuevos_mes";
    $stmt = $conn->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


/* 🔹 Obtener todos los clientes */
function obtenerClientes($conn) {
    $sql = "SELECT c.*, 
                   z.nombre_zona, 
                   e.nombre_empleado, 
                   est.descripcion AS estatus_cliente
            FROM CLIENTE c
            LEFT JOIN ZONA z ON c.id_zona = z.id_zona
            LEFT JOIN EMPLEADO e ON c.id_empleado = e.id_empleado
            LEFT JOIN CAT_ESTATUS_CLIENTE est ON c.id_estatus = est.id_estatus
            ORDER BY c.id_cliente DESC";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* 🔹 Obtener cliente por ID */
function obtenerClientePorId($conn, $id) {
    $stmt = $conn->prepare("SELECT c.*, 
                                   z.nombre_zona, 
                                   e.nombre_empleado, 
                                   est.descripcion AS estatus_cliente
                            FROM CLIENTE c
                            LEFT JOIN ZONA z ON c.id_zona = z.id_zona
                            LEFT JOIN EMPLEADO e ON c.id_empleado = e.id_empleado
                            LEFT JOIN CAT_ESTATUS_CLIENTE est ON c.id_estatus = est.id_estatus
                            WHERE c.id_cliente = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* 🔹 Agregar cliente */
function agregarCliente($conn, $data) {
    $sql = "INSERT INTO CLIENTE (
        id_empleado, id_zona, apellido_paterno, apellido_materno, nombre_cliente,
        telefono1, telefono2, correo_cliente, calle, numero, colonia,
        municipio, codigo_postal, id_estatus, observaciones
    ) VALUES (
        :id_empleado, :id_zona, :apellido_paterno, :apellido_materno, :nombre_cliente,
        :telefono1, :telefono2, :correo_cliente, :calle, :numero, :colonia,
        :municipio, :codigo_postal, :id_estatus, :observaciones
    )";

    $stmt = $conn->prepare($sql);

    // Mapear los campos, asegurando que existan y no estén vacíos
    $params = [
        ':id_empleado' => !empty($data['id_empleado']) ? $data['id_empleado'] : null,
        ':id_zona' => !empty($data['id_zona']) ? $data['id_zona'] : null,
        ':apellido_paterno' => $data['apellido_paterno'] ?? '',
        ':apellido_materno' => $data['apellido_materno'] ?? null,
        ':nombre_cliente' => $data['nombre_cliente'] ?? '',
        ':telefono1' => $data['telefono1'] ?? '',
        ':telefono2' => $data['telefono2'] ?? null,
        ':correo_cliente' => $data['correo_cliente'] ?? null,
        ':calle' => $data['calle'] ?? null,
        ':numero' => $data['numero'] ?? null,
        ':colonia' => $data['colonia'] ?? null,
        ':municipio' => $data['municipio'] ?? null,
        ':codigo_postal' => $data['codigo_postal'] ?? null,
        ':id_estatus' => !empty($data['id_estatus']) ? $data['id_estatus'] : 1,
        ':observaciones' => $data['observaciones'] ?? null
    ];

    $stmt->execute($params);

    return $conn->lastInsertId();
}


/* 🔹 Eliminar cliente */
function eliminarCliente($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM CLIENTE WHERE id_cliente = ?");
    $stmt->execute([$id]);
}
?>
