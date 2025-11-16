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
        // pasar directamente $_POST al modelo (el modelo filtrará lo necesario)
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
        // validar id
        $id = intval($_POST['id_cliente']);
        $_POST['id_cliente'] = $id;

        $ok = actualizarCliente($conn, $_POST);
        if ($ok) {
            header("Location: ../home.php?page=cliente&msg=editado");
            exit;
        } else {
            throw new Exception("No se pudo actualizar el cliente.");
        }
    } catch (Exception $e) {
        die("Error al editar cliente: " . $e->getMessage());
    }
}

// ============================
// ELIMINAR CLIENTE
// ============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'eliminar') {
    try {
        $id = intval($_POST['id_cliente']);
        eliminarCliente($conn, $id);
        header("Location: ../home.php?page=cliente&msg=eliminado");
        exit;
    } catch (PDOException $e) {
        die("Error al eliminar cliente: " . $e->getMessage());
    }
}
?>
