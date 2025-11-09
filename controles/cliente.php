<?php
include_once(__DIR__ . '/../datos/clienteDatos.php');

$accion = $_POST['accion'] ?? '';
switch ($accion) {
    case 'agregar':
        agregarCliente($conn, [
            'id_empleado' => $_POST['id_empleado'] ?: null,
            'id_zona' => $_POST['id_zona'] ?: null,
            'ap' => $_POST['apellido_paterno'],
            'am' => $_POST['apellido_materno'],
            'nombre' => $_POST['nombre_cliente'],
            'tel1' => $_POST['telefono1'],
            'tel2' => $_POST['telefono2'],
            'correo' => $_POST['correo_cliente'],
            'calle' => $_POST['calle'],
            'numero' => $_POST['numero'],
            'colonia' => $_POST['colonia'],
            'municipio' => $_POST['municipio'],
            'cp' => $_POST['codigo_postal'],
            'obs' => $_POST['observaciones']
        ]);
        header("Location: ../home.php?page=cliente");
        exit;

    case 'eliminar':
        eliminarCliente($conn, $_POST['id_cliente']);
        header("Location: ../home.php?page=cliente");
        exit;

            case 'editar':
        $sql = "UPDATE CLIENTE SET 
                    id_empleado = :id_empleado,
                    id_zona = :id_zona,
                    apellido_paterno = :ap,
                    apellido_materno = :am,
                    nombre_cliente = :nombre,
                    telefono1 = :tel1,
                    telefono2 = :tel2,
                    correo_cliente = :correo,
                    calle = :calle,
                    numero = :numero,
                    colonia = :colonia,
                    municipio = :municipio,
                    codigo_postal = :cp,
                    observaciones = :obs
                WHERE id_cliente = :id_cliente";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'id_empleado' => $_POST['id_empleado'] ?: null,
            'id_zona' => $_POST['id_zona'] ?: null,
            'ap' => $_POST['apellido_paterno'],
            'am' => $_POST['apellido_materno'],
            'nombre' => $_POST['nombre_cliente'],
            'tel1' => $_POST['telefono1'],
            'tel2' => $_POST['telefono2'],
            'correo' => $_POST['correo_cliente'],
            'calle' => $_POST['calle'],
            'numero' => $_POST['numero'],
            'colonia' => $_POST['colonia'],
            'municipio' => $_POST['municipio'],
            'cp' => $_POST['codigo_postal'],
            'obs' => $_POST['observaciones'],
            'id_cliente' => $_POST['id_cliente']
        ]);
        header("Location: ../home.php?page=cliente");
        exit;

}

?>
