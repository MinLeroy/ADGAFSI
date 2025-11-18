<?php
// controles/instalacion.php
include_once(__DIR__ . '/../datos/instalacionDatos.php');

if (!isset($conn)) {
    die("No hay conexión con la base de datos");
}

// Convierte datetime-local (YYYY-MM-DDTHH:MM or with seconds) a SQL DATETIME Y-m-d H:i:s
function transformarFecha($fecha) {
    if (empty($fecha)) return null;
    $fecha = str_replace('T', ' ', $fecha);
    if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $fecha)) {
        $fecha .= ':00';
    }
    $ts = strtotime($fecha);
    if ($ts === false) return null;
    return date('Y-m-d H:i:s', $ts);
}

// AGREGAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'agregar') {
    try {
        $data = [];
        $data['id_contrato'] = intval($_POST['id_contrato'] ?? 0);
        $data['tecnico_asignado'] = !empty($_POST['tecnico_asignado']) ? intval($_POST['tecnico_asignado']) : null;
        $data['fecha_programada'] = transformarFecha($_POST['fecha_programada'] ?? null);
        $data['fecha_realizada'] = transformarFecha($_POST['fecha_realizada'] ?? null);
        $data['estatus_instalacion'] = $_POST['estatus_instalacion'] ?? 'Pendiente';
        $data['comentarios'] = !empty($_POST['comentarios']) ? trim($_POST['comentarios']) : null;

        agregarInstalacion($conn, $data);
        header("Location: ../home.php?page=instalacion&msg=ok");
        exit;
    } catch (PDOException $e) {
        die("Error al guardar instalación: " . $e->getMessage());
    }
}

// EDITAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'editar') {
    try {
        $id = intval($_POST['id_instalacion'] ?? 0);
        $data = [];
        $data['id_contrato'] = intval($_POST['id_contrato'] ?? 0);
        $data['tecnico_asignado'] = !empty($_POST['tecnico_asignado']) ? intval($_POST['tecnico_asignado']) : null;
        $data['fecha_programada'] = transformarFecha($_POST['fecha_programada'] ?? null);
        $data['fecha_realizada'] = transformarFecha($_POST['fecha_realizada'] ?? null);
        $data['estatus_instalacion'] = $_POST['estatus_instalacion'] ?? 'Pendiente';
        $data['comentarios'] = !empty($_POST['comentarios']) ? trim($_POST['comentarios']) : null;

        editarInstalacion($conn, $id, $data);
        header("Location: ../home.php?page=instalacion&msg=editado");
        exit;
    } catch (PDOException $e) {
        die("Error al editar instalación: " . $e->getMessage());
    }
}

// ELIMINAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'eliminar') {
    try {
        $id = intval($_POST['id_instalacion'] ?? 0);
        eliminarInstalacion($conn, $id);
        header("Location: ../home.php?page=instalacion&msg=eliminado");
        exit;
    } catch (PDOException $e) {
        die("Error al eliminar instalación: " . $e->getMessage());
    }
}
