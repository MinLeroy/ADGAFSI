<?php
include_once(__DIR__ . '/../BD/conexion.php');

/* 🔹 Obtener resumen de clientes */
function resumenClientes($conn) {
    $sql = "
        SELECT 
            (SELECT COUNT(*) FROM CLIENTE WHERE estatus_cliente = 'Activo') AS activos,
            (SELECT COUNT(*) FROM CLIENTE WHERE estatus_cliente = 'Inactivo') AS inactivos,
            (SELECT COUNT(*) FROM CLIENTE 
                WHERE MONTH(fecha_registro_cliente) = MONTH(GETDATE())
                AND YEAR(fecha_registro_cliente) = YEAR(GETDATE())) AS nuevos_mes";
    $stmt = $conn->query($sql);
    return $stmt->fetch();
}

/* 🔹 Obtener todos los clientes */
function obtenerClientes($conn) {
    $sql = "SELECT c.*, z.nombre_zona, e.nombre_empleado 
            FROM CLIENTE c
            LEFT JOIN ZONA z ON c.id_zona = z.id_zona
            LEFT JOIN EMPLEADO e ON c.id_empleado = e.id_empleado
            ORDER BY c.id_cliente DESC";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll();
}

/* 🔹 Obtener cliente por ID */
function obtenerClientePorId($conn, $id) {
    $stmt = $conn->prepare("SELECT c.*, z.nombre_zona, e.nombre_empleado 
                            FROM CLIENTE c
                            LEFT JOIN ZONA z ON c.id_zona = z.id_zona
                            LEFT JOIN EMPLEADO e ON c.id_empleado = e.id_empleado
                            WHERE c.id_cliente = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/* 🔹 Agregar cliente */
function agregarCliente($conn, $data) {
    $sql = "INSERT INTO CLIENTE (
                id_empleado, id_zona, apellido_paterno, apellido_materno, 
                nombre_cliente, telefono1, telefono2, correo_cliente,
                calle, numero, colonia, municipio, codigo_postal, observaciones
            ) VALUES (
                :id_empleado, :id_zona, :ap, :am, :nombre, :tel1, :tel2, :correo,
                :calle, :numero, :colonia, :municipio, :cp, :obs
            )";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

/* 🔹 Eliminar cliente */
function eliminarCliente($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM CLIENTE WHERE id_cliente = ?");
    $stmt->execute([$id]);
}
?>
