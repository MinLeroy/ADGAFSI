<?php
include_once(__DIR__ . '/../datos/clienteDatos.php');

if (!isset($conn)) {
    die("No hay conexión con la base de datos");
}

// ============================
// AGREGAR CLIENTE
// ============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'agregar') {
    try {
        agregarCliente($conn, $_POST);
        header("Location: ../home.php?page=cliente&msg=ok");
        exit;
    } catch (PDOException $e) {
        die("Error al guardar cliente: " . $e->getMessage());
    }
}

// ============================
// EDITAR CLIENTE
// ============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'editar') {
    try {
        $id = intval($_POST['id_cliente']);
        $sql = "UPDATE CLIENTE SET 
                    id_empleado = :id_empleado,
                    id_zona = :id_zona,
                    apellido_paterno = :apellido_paterno,
                    apellido_materno = :apellido_materno,
                    nombre_cliente = :nombre_cliente,
                    telefono1 = :telefono1,
                    telefono2 = :telefono2,
                    correo_cliente = :correo_cliente,
                    calle = :calle,
                    numero = :numero,
                    colonia = :colonia,
                    municipio = :municipio,
                    codigo_postal = :codigo_postal,
                    id_estatus = :id_estatus,
                    observaciones = :observaciones
                WHERE id_cliente = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id_empleado' => $_POST['id_empleado'] ?: null,
            ':id_zona' => $_POST['id_zona'] ?: null,
            ':apellido_paterno' => $_POST['apellido_paterno'],
            ':apellido_materno' => $_POST['apellido_materno'],
            ':nombre_cliente' => $_POST['nombre_cliente'],
            ':telefono1' => $_POST['telefono1'],
            ':telefono2' => $_POST['telefono2'],
            ':correo_cliente' => $_POST['correo_cliente'],
            ':calle' => $_POST['calle'],
            ':numero' => $_POST['numero'],
            ':colonia' => $_POST['colonia'],
            ':municipio' => $_POST['municipio'],
            ':codigo_postal' => $_POST['codigo_postal'],
            ':id_estatus' => $_POST['id_estatus'],
            ':observaciones' => $_POST['observaciones'],
            ':id' => $id
        ]);
        header("Location: ../home.php?page=cliente&msg=editado");
        exit;
    } catch (PDOException $e) {
        die("Error al editar cliente: " . $e->getMessage());
    }
}

// ============================
// ELIMINAR CLIENTE
// ============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'eliminar') {
    try {
        $id = intval($_POST['id_cliente']);
        $stmt = $conn->prepare("DELETE FROM CLIENTE WHERE id_cliente = :id");
        $stmt->execute([':id' => $id]);
        header("Location: ../home.php?page=cliente&msg=eliminado");
        exit;
    } catch (PDOException $e) {
        die("Error al eliminar cliente: " . $e->getMessage());
    }
}
