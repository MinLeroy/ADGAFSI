<?php
// controles/articulo.php

// 1️⃣ Cargar la conexión SIEMPRE
require_once(__DIR__ . '/../BD/conexion.php');

// 2️⃣ Cargar funciones de artículos
require_once(__DIR__ . '/../datos/articuloDatos.php');

if (!isset($conn)) { die("Error: sin conexión a la base de datos"); }

// Función para limpiar decimales
function sanitize_decimal($v) {
    if ($v === '' || $v === null) return 0;
    $v = str_replace(',', '', $v);
    return floatval($v);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $accion = $_POST['accion'] ?? '';

    if ($accion === 'agregar') {

        $data = [
            'nombre_articulo'     => $_POST['nombre_articulo'],
            'tipo_articulo'       => $_POST['tipo_articulo'],
            'marca_articulo'      => $_POST['marca_articulo'],
            'descripcion_articulo'=> $_POST['descripcion_articulo'],
            'precio_unitario'     => sanitize_decimal($_POST['precio_unitario']),
            'cantidad_disponible' => intval($_POST['cantidad_disponible'])
        ];

        agregarArticulo($conn, $data);
        header("Location: ../home.php?page=articulo&msg=ok");
        exit;
    }

    if ($accion === 'editar') {

        $id = intval($_POST['id_articulo']);

        $data = [
            'nombre_articulo'     => $_POST['nombre_articulo'],
            'tipo_articulo'       => $_POST['tipo_articulo'],
            'marca_articulo'      => $_POST['marca_articulo'],
            'descripcion_articulo'=> $_POST['descripcion_articulo'],
            'precio_unitario'     => sanitize_decimal($_POST['precio_unitario']),
            'cantidad_disponible' => intval($_POST['cantidad_disponible'])
        ];

        editarArticulo($conn, $id, $data);
        header("Location: ../home.php?page=articulo&msg=editado");
        exit;
    }

    if ($accion === 'eliminar') {
        eliminarArticulo($conn, intval($_POST['id_articulo']));
        header("Location: ../home.php?page=articulo&msg=eliminado");
        exit;
    }
}

header("Location: ../home.php?page=articulo");
exit;
