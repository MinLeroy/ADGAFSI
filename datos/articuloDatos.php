<?php
// datos/articuloDatos.php
require_once(__DIR__ . '/../BD/conexion.php');

// --- RESUMEN PARA LAS TARJETAS ---
function obtenerResumenArticulos($conn) {
    $sql = "
        SELECT 
            (SELECT COUNT(*) FROM ARTICULO) AS total,
            (SELECT SUM(cantidad_disponible) FROM ARTICULO) AS inventario,
            (SELECT COUNT(*) FROM ARTICULO WHERE cantidad_disponible = 0) AS agotados
    ";
    return $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
}

// --- LISTA COMPLETA ---
function obtenerArticulos($conn) {
    $sql = "
        SELECT id_articulo, nombre_articulo, tipo_articulo, marca_articulo,
               descripcion_articulo, precio_unitario, cantidad_disponible
        FROM ARTICULO
        ORDER BY nombre_articulo ASC
    ";
    return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// --- OBTENER UNO ---
function obtenerArticulo($conn, $id) {
    $sql = "SELECT * FROM ARTICULO WHERE id_articulo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// --- AGREGAR ---
function agregarArticulo($conn, $data) {
    $sql = "INSERT INTO ARTICULO
            (nombre_articulo, tipo_articulo, marca_articulo, descripcion_articulo,
             precio_unitario, cantidad_disponible)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $data['nombre_articulo'],
        $data['tipo_articulo'],
        $data['marca_articulo'],
        $data['descripcion_articulo'],
        $data['precio_unitario'],
        $data['cantidad_disponible']
    ]);
}

// --- EDITAR ---
function editarArticulo($conn, $id, $data) {
    $sql = "UPDATE ARTICULO SET
            nombre_articulo=?, tipo_articulo=?, marca_articulo=?,
            descripcion_articulo=?, precio_unitario=?, cantidad_disponible=?
            WHERE id_articulo=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $data['nombre_articulo'],
        $data['tipo_articulo'],
        $data['marca_articulo'],
        $data['descripcion_articulo'],
        $data['precio_unitario'],
        $data['cantidad_disponible'],
        $id
    ]);
}

// --- ELIMINAR ---
function eliminarArticulo($conn, $id) {
    $sql = "DELETE FROM ARTICULO WHERE id_articulo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
}
