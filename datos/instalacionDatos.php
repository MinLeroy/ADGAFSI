<?php
// datos/instalacionDatos.php
include_once(__DIR__ . '/../BD/conexion.php');

/* Resumen de instalaciones */
function resumenInstalaciones($conn) {
    $sql = "SELECT
                (SELECT COUNT(*) FROM INSTALACION WHERE estatus_instalacion = 'Pendiente') AS pendientes,
                (SELECT COUNT(*) FROM INSTALACION WHERE estatus_instalacion = 'Realizada') AS realizadas,
                (SELECT COUNT(*) FROM INSTALACION WHERE MONTH(fecha_programada) = MONTH(GETDATE()) AND YEAR(fecha_programada) = YEAR(GETDATE())) AS programadas_mes
            ";
    $stmt = $conn->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* Obtener instalaciones (lista) */
function obtenerInstalaciones($conn) {
    $sql = "
    SELECT
        i.id_instalacion,
        i.id_contrato,
        i.tecnico_asignado,
        i.fecha_programada,
        i.fecha_realizada,
        i.estatus_instalacion,
        i.comentarios,

        -- datos del contrato + cliente + servicio
        c.id_cliente,
        CONCAT(cl.nombre_cliente, ' ', cl.apellido_paterno, ISNULL(CONCAT(' ', cl.apellido_materno), '')) AS cliente_nombre_completo,
        s.id_servicio,
        s.nombre_servicio,
        CONCAT(e.nombre_empleado, ' ', e.apellido_paterno, ISNULL(CONCAT(' ', e.apellido_materno), '')) AS tecnico_nombre_completo

    FROM INSTALACION i
    INNER JOIN CONTRATO c ON i.id_contrato = c.id_contrato
    INNER JOIN CLIENTE cl ON c.id_cliente = cl.id_cliente
    INNER JOIN SERVICIO s ON c.id_servicio = s.id_servicio
    LEFT JOIN EMPLEADO e ON i.tecnico_asignado = e.id_empleado
    ORDER BY i.id_instalacion DESC
    ";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* Obtener instalación por id */
function obtenerInstalacionPorId($conn, $id) {
    $sql = "
    SELECT
        i.id_instalacion,
        i.id_contrato,
        i.tecnico_asignado,
        i.fecha_programada,
        i.fecha_realizada,
        i.estatus_instalacion,
        i.comentarios,

        -- contrato + cliente + servicio
        c.id_contrato,
        c.id_cliente,
        CONCAT(cl.nombre_cliente, ' ', cl.apellido_paterno, ISNULL(CONCAT(' ', cl.apellido_materno), '')) AS cliente_nombre_completo,
        cl.telefono1, cl.telefono2, cl.calle, cl.numero, cl.colonia, cl.municipio, cl.codigo_postal,
        s.id_servicio,
        s.nombre_servicio,
        s.tipo_servicio,
        s.velocidad_megas,
        s.costo_primer_mes,
        s.costo_regular,

        CONCAT(e.nombre_empleado, ' ', e.apellido_paterno, ISNULL(CONCAT(' ', e.apellido_materno), '')) AS tecnico_nombre_completo,
        emp.* -- datos completos del técnico por si los necesitas

    FROM INSTALACION i
    INNER JOIN CONTRATO c ON i.id_contrato = c.id_contrato
    INNER JOIN CLIENTE cl ON c.id_cliente = cl.id_cliente
    INNER JOIN SERVICIO s ON c.id_servicio = s.id_servicio
    LEFT JOIN EMPLEADO e ON i.tecnico_asignado = e.id_empleado
    LEFT JOIN EMPLEADO emp ON i.tecnico_asignado = emp.id_empleado
    WHERE i.id_instalacion = :id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* Agregar instalación */
function agregarInstalacion($conn, $data) {
    $sql = "INSERT INTO INSTALACION (id_contrato, tecnico_asignado, fecha_programada, fecha_realizada, estatus_instalacion, comentarios)
            VALUES (:id_contrato, :tecnico_asignado, :fecha_programada, :fecha_realizada, :estatus_instalacion, :comentarios)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id_contrato' => $data['id_contrato'],
        ':tecnico_asignado' => $data['tecnico_asignado'] ?? null,
        ':fecha_programada' => $data['fecha_programada'] ?? null,
        ':fecha_realizada' => $data['fecha_realizada'] ?? null,
        ':estatus_instalacion' => $data['estatus_instalacion'] ?? 'Pendiente',
        ':comentarios' => $data['comentarios'] ?? null
    ]);
    return $conn->lastInsertId();
}

/* Editar instalación */
function editarInstalacion($conn, $id, $data) {
    $sql = "UPDATE INSTALACION SET
                id_contrato = :id_contrato,
                tecnico_asignado = :tecnico_asignado,
                fecha_programada = :fecha_programada,
                fecha_realizada = :fecha_realizada,
                estatus_instalacion = :estatus_instalacion,
                comentarios = :comentarios
            WHERE id_instalacion = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id_contrato' => $data['id_contrato'],
        ':tecnico_asignado' => $data['tecnico_asignado'] ?? null,
        ':fecha_programada' => $data['fecha_programada'] ?? null,
        ':fecha_realizada' => $data['fecha_realizada'] ?? null,
        ':estatus_instalacion' => $data['estatus_instalacion'] ?? 'Pendiente',
        ':comentarios' => $data['comentarios'] ?? null,
        ':id' => $id
    ]);
}

/* Eliminar instalación */
function eliminarInstalacion($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM INSTALACION WHERE id_instalacion = ?");
    $stmt->execute([$id]);
}

/* Obtener detalles de material usado en una instalación */
function obtenerDetallesPorInstalacion($conn, $id_instalacion) {
    $sql = "
    SELECT di.*, a.nombre_articulo
    FROM DETALLE_INSTALACION di
    LEFT JOIN ARTICULO a ON di.id_articulo = a.id_articulo
    WHERE di.id_instalacion = :id
    ORDER BY di.id_detalle DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id_instalacion]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
