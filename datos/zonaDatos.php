<?php
require_once(__DIR__ . "/../BD/conexion.php");

/* ===========================
   OBTENER TODAS LAS ZONAS
   =========================== */
function obtenerZonas(PDO $conn)
{
    $sql = "SELECT * FROM ZONA ORDER BY nombre_zona";
    return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

/* ===========================
   OBTENER ZONA POR ID
   =========================== */
function obtenerZonaPorId(PDO $conn, $id)
{
    $sql = "SELECT * FROM ZONA WHERE id_zona = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* ===========================
   AGREGAR ZONA
   =========================== */
function agregarZona(PDO $conn, $data)
{
    $sql = "INSERT INTO ZONA
            (nombre_zona, direccion_zona, capacidad_megas, descripcion_zona)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        $data['nombre_zona'],
        $data['direccion_zona'] ?? null,
        $data['capacidad_megas'] ?? null,
        $data['descripcion_zona'] ?? null
    ]);
}

/* ===========================
   EDITAR ZONA
   =========================== */
function editarZona(PDO $conn, $data)
{
    $sql = "UPDATE ZONA SET
                nombre_zona = ?,
                direccion_zona = ?,
                capacidad_megas = ?,
                descripcion_zona = ?
            WHERE id_zona = ?";

    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        $data['nombre_zona'],
        $data['direccion_zona'] ?? null,
        $data['capacidad_megas'] ?? null,
        $data['descripcion_zona'] ?? null,
        $data['id_zona']
    ]);
}

/* ===========================
   ELIMINAR ZONA
   =========================== */
function eliminarZona(PDO $conn, $id)
{
    $sql = "DELETE FROM ZONA WHERE id_zona = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$id]);
}
