<?php
require_once("../BD/conexion.php");
require_once("../datos/servicioDatos.php");

// AGREGAR
if ($_POST['accion'] === "agregar") {
    agregarServicio($conn, $_POST);
    header("Location: ../home.php?page=servicio/servicio&msg=ok");
    exit;
}

// EDITAR
if ($_POST['accion'] === "editar") {
    editarServicio($conn, $_POST);
    header("Location: ../home.php?page=servicio/servicio&msg=editado");
    exit;
}

// ELIMINAR
if ($_POST['accion'] === "eliminar") {
    eliminarServicio($conn, $_POST['id_servicio']);
    header("Location: ../home.php?page=servicio/servicio&msg=eliminado");
    exit;
}
