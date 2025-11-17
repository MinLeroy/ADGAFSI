<?php
require_once(__DIR__ . "/../BD/conexion.php");

/* ===============================
   OBTENER RESUMEN DE SERVICIOS
   =============================== */
function resumenServicios($conn)
{
    $sql = "SELECT
                SUM(CASE WHEN estado_servicio = 1 THEN 1 ELSE 0 END) AS activos,
                SUM(CASE WHEN estado_servicio = 0 THEN 1 ELSE 0 END) AS inactivos,
                SUM(CASE WHEN requiere_instalacion = 1 THEN 1 ELSE 0 END) AS requieren_instalacion,
                COUNT(*) AS total
            FROM SERVICIO";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* ===============================
   OBTENER LISTA COMPLETA
   =============================== */
function obtenerServicios($conn)
{
    $sql = "SELECT id_servicio, nombre_servicio, tipo_servicio, velocidad_megas,
            costo_regular, estado_servicio
            FROM SERVICIO
            ORDER BY id_servicio DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* ====================================
    OBTENER SERVICIO POR ID (PARA VER/EDITAR)
   ==================================== */
function obtenerServicioPorId($conn, $id)
{
    $sql = "SELECT * FROM SERVICIO WHERE id_servicio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* ===============================
   INSERTAR NUEVO SERVICIO
   =============================== */
function agregarServicio($conn, $data)
{
    $sql = "INSERT INTO SERVICIO
            (nombre_servicio, tipo_servicio, velocidad_megas,
            costo_primer_mes, costo_regular, requiere_instalacion,
            descripcion_servicio, estado_servicio)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        $data['nombre_servicio'],
        $data['tipo_servicio'],
        $data['velocidad_megas'],
        $data['costo_primer_mes'],
        $data['costo_regular'],
        $data['requiere_instalacion'],
        $data['descripcion_servicio'],
        $data['estado_servicio'],
    ]);
}

/* ===============================
   ACTUALIZAR SERVICIO
   =============================== */
function editarServicio($conn, $data)
{
    $sql = "UPDATE SERVICIO SET
            nombre_servicio = ?,
            tipo_servicio = ?,
            velocidad_megas = ?,
            costo_primer_mes = ?,
            costo_regular = ?,
            requiere_instalacion = ?,
            descripcion_servicio = ?,
            estado_servicio = ?
            WHERE id_servicio = ?";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        $data['nombre_servicio'],
        $data['tipo_servicio'],
        $data['velocidad_megas'],
        $data['costo_primer_mes'],
        $data['costo_regular'],
        $data['requiere_instalacion'],
        $data['descripcion_servicio'],
        $data['estado_servicio'],
        $data['id_servicio']
    ]);
}

/* ===============================
   ELIMINAR SERVICIO
   =============================== */
function eliminarServicio($conn, $id)
{
    $sql = "DELETE FROM SERVICIO WHERE id_servicio = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$id]);
}

function contarServiciosInstalacion($conn)
{
    $sql = "SELECT COUNT(*) AS total FROM servicio WHERE requiere_instalacion = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
}
