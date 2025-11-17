<?php
// controles/contrato.php
include_once(__DIR__ . '/../datos/contratoDatos.php');

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

function sanitizeMonto($v) {
    if ($v === '' || $v === null) return null;
    $v = str_replace(',', '', $v);
    if (!is_numeric($v)) return null;
    return number_format((float)$v, 2, '.', '');
}

// AGREGAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'agregar') {
    try {
        $data = [];
        $data['id_cliente'] = intval($_POST['id_cliente'] ?? 0);
        $data['id_servicio'] = intval($_POST['id_servicio'] ?? 0);
        $data['id_empleado'] = !empty($_POST['id_empleado']) ? intval($_POST['id_empleado']) : null;
        $data['fecha_contrato'] = transformarFecha($_POST['fecha_contrato'] ?? null);
        $data['estatus_contrato'] = $_POST['estatus_contrato'] ?? 'Activo';
        $data['estado_instalacion'] = $_POST['estado_instalacion'] ?? 'Pendiente';
        $data['monto_total'] = sanitizeMonto($_POST['monto_total'] ?? 0) ?? 0;
        $data['observaciones'] = !empty($_POST['observaciones']) ? trim($_POST['observaciones']) : null;

        agregarContrato($conn, $data);
        header("Location: ../home.php?page=contrato&msg=ok");
        exit;
    } catch (PDOException $e) {
        die("Error al guardar contrato: " . $e->getMessage());
    }
}

// EDITAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'editar') {
    try {
        $id = intval($_POST['id_contrato'] ?? 0);
        $data = [];
        $data['id_cliente'] = intval($_POST['id_cliente'] ?? 0);
        $data['id_servicio'] = intval($_POST['id_servicio'] ?? 0);
        $data['id_empleado'] = !empty($_POST['id_empleado']) ? intval($_POST['id_empleado']) : null;
        $data['fecha_contrato'] = transformarFecha($_POST['fecha_contrato'] ?? null);
        $data['estatus_contrato'] = $_POST['estatus_contrato'] ?? 'Activo';
        $data['estado_instalacion'] = $_POST['estado_instalacion'] ?? 'Pendiente';
        $data['monto_total'] = sanitizeMonto($_POST['monto_total'] ?? 0) ?? 0;
        $data['observaciones'] = !empty($_POST['observaciones']) ? trim($_POST['observaciones']) : null;

        editarContrato($conn, $id, $data);
        header("Location: ../home.php?page=contrato&msg=editado");
        exit;
    } catch (PDOException $e) {
        die("Error al editar contrato: " . $e->getMessage());
    }
}

// ELIMINAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'eliminar') {
    try {
        $id = intval($_POST['id_contrato'] ?? 0);
        eliminarContrato($conn, $id);
        header("Location: ../home.php?page=contrato&msg=eliminado");
        exit;
    } catch (PDOException $e) {
        die("Error al eliminar contrato: " . $e->getMessage());
    }
}
