<?php
require_once(__DIR__ . "/../datos/zonaDatos.php");

$accion = $_POST['accion'] ?? null;

switch ($accion) {

    case 'agregar':
        if (agregarZona($conn, $_POST)) {
            header("Location: /ADGAFSI/home.php?page=zona&msg=ok");
        }
        break;

    case 'editar':
        if (editarZona($conn, $_POST)) {
            header("Location: /ADGAFSI/home.php?page=zona&msg=editado");
        }
        break;

    case 'eliminar':
        if (eliminarZona($conn, $_POST['id_zona'])) {
            header("Location: /ADGAFSI/home.php?page=zona&msg=eliminado");
        }
        break;

    default:
        echo "Acción no válida";
}
