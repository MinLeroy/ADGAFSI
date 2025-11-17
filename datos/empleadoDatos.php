<?php
require_once(__DIR__ . "/../BD/conexion.php");

/* ===========================
   OBTENER TODOS LOS EMPLEADOS
   =========================== */
function obtenerEmpleados(PDO $conn)
{
    $sql = "SELECT * FROM EMPLEADO ORDER BY nombre_empleado";
    return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

/* ===========================
   OBTENER EMPLEADO POR ID
   =========================== */
function obtenerEmpleadoPorId(PDO $conn, $id)
{
    $sql = "SELECT * FROM EMPLEADO WHERE id_empleado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* ===========================
   AGREGAR EMPLEADO
   =========================== */
function agregarEmpleado(PDO $conn, $data)
{
    $sql = "INSERT INTO EMPLEADO
            (apellido_paterno, apellido_materno, nombre_empleado, telefono_empleado, correo_empleado, puesto, estatus_empleado, fecha_registro_empleado)
            VALUES (?, ?, ?, ?, ?, ?, ?, GETDATE())";

    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        $data['apellido_paterno'],
        $data['apellido_materno'],
        $data['nombre_empleado'],
        $data['telefono_empleado'],
        $data['correo_empleado'],
        $data['puesto'],
        $data['estatus_empleado']
    ]);
}

/* ===========================
   EDITAR EMPLEADO
   =========================== */
function editarEmpleado(PDO $conn, $data)
{
    $sql = "UPDATE EMPLEADO SET
                apellido_paterno = ?,
                apellido_materno = ?,
                nombre_empleado = ?,
                telefono_empleado = ?,
                correo_empleado = ?,
                puesto = ?,
                estatus_empleado = ?
            WHERE id_empleado = ?";

    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        $data['apellido_paterno'],
        $data['apellido_materno'],
        $data['nombre_empleado'],
        $data['telefono_empleado'],
        $data['correo_empleado'],
        $data['puesto'],
        $data['estatus_empleado'],
        $data['id_empleado']
    ]);
}

/* ===========================
   ELIMINAR EMPLEADO
   =========================== */
function eliminarEmpleado(PDO $conn, $id)
{
    $sql = "DELETE FROM EMPLEADO WHERE id_empleado = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$id]);
}
