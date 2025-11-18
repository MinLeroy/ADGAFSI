<?php
// controles/pago.php
include_once(__DIR__ . '/../datos/pagoDatos.php');
if (!isset($conn)) { die("No hay conexión con la base de datos"); }

function transformarFecha($fecha) {
    if (empty($fecha)) return null;
    $fecha = str_replace('T', ' ', $fecha);
    if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $fecha)) { $fecha .= ':00'; }
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
        $data['id_contrato'] = intval($_POST['id_contrato'] ?? 0);
        $data['fecha_pago'] = transformarFecha($_POST['fecha_pago'] ?? null);
        $data['monto_pago'] = sanitizeMonto($_POST['monto_pago'] ?? 0) ?? 0;
        $data['id_metodo_pago'] = !empty($_POST['id_metodo_pago']) ? intval($_POST['id_metodo_pago']) : null;
        $data['ticket_pago'] = !empty($_POST['ticket_pago']) ? trim($_POST['ticket_pago']) : null;
        $data['fecha_proximo_pago'] = transformarFecha($_POST['fecha_proximo_pago'] ?? null);
        $data['estatus_pago'] = $_POST['estatus_pago'] ?? 'Pendiente';
        agregarPago($conn, $data);
        header("Location: ../home.php?page=pago&msg=ok");
        exit;
    } catch (PDOException $e) {
        die("Error al guardar pago: " . $e->getMessage());
    }
}

// EDITAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'editar') {
    try {
        $id = intval($_POST['id_pago'] ?? 0);
        $data = [];
        $data['id_contrato'] = intval($_POST['id_contrato'] ?? 0);
        $data['fecha_pago'] = transformarFecha($_POST['fecha_pago'] ?? null);
        $data['monto_pago'] = sanitizeMonto($_POST['monto_pago'] ?? 0) ?? 0;
        $data['id_metodo_pago'] = !empty($_POST['id_metodo_pago']) ? intval($_POST['id_metodo_pago']) : null;
        $data['ticket_pago'] = !empty($_POST['ticket_pago']) ? trim($_POST['ticket_pago']) : null;
        $data['fecha_proximo_pago'] = transformarFecha($_POST['fecha_proximo_pago'] ?? null);
        $data['estatus_pago'] = $_POST['estatus_pago'] ?? 'Pendiente';
        editarPago($conn, $id, $data);
        header("Location: ../home.php?page=pago&msg=editado");
        exit;
    } catch (PDOException $e) {
        die("Error al editar pago: " . $e->getMessage());
    }
}

// ELIMINAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'eliminar') {
    try {
        $id = intval($_POST['id_pago'] ?? 0);
        eliminarPago($conn, $id);
        header("Location: ../home.php?page=pago&msg=eliminado");
        exit;
    } catch (PDOException $e) {
        die("Error al eliminar pago: " . $e->getMessage());
    }
}
