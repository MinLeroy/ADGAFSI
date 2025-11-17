<?php
require_once(__DIR__ . "/../datos/empleadoDatos.php");

$accion = $_POST['accion'] ?? null;

switch ($accion) {

    case 'agregar':
        if (agregarEmpleado($conn, $_POST)) {
            header("Location: /ADGAFSI/home.php?page=empleado&msg=ok");
        }
        break;

    case 'editar':
        if (editarEmpleado($conn, $_POST)) {
            header("Location: /ADGAFSI/home.php?page=empleado&msg=editado");
        }
        break;

    case 'eliminar':
        if (eliminarEmpleado($conn, $_POST['id_empleado'])) {
            header("Location: /ADGAFSI/home.php?page=empleado&msg=eliminado");
        }
        break;

    default:
        echo "Acción no válida";
}
