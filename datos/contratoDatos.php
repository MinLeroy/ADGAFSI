<?php
// datos/contratoDatos.php
include_once(__DIR__ . '/../BD/conexion.php');

/* Resumen de contratos */
function resumenContratos($conn) {
    $sql = "SELECT
                (SELECT COUNT(*) FROM CONTRATO WHERE estatus_contrato = 'Activo') AS activos,
                (SELECT COUNT(*) FROM CONTRATO WHERE estatus_contrato = 'Cancelado') AS cancelados,
                (SELECT COUNT(*) FROM CONTRATO WHERE MONTH(fecha_contrato) = MONTH(GETDATE()) AND YEAR(fecha_contrato) = YEAR(GETDATE())) AS nuevos_mes
            ";
    $stmt = $conn->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* Obtener contratos (lista) - JOIN completo pero lista principal mostrará sólo 4 campos */
function obtenerContratos($conn) {
    $sql = "
    SELECT
        c.id_contrato,

        -- CLIENTE
        cl.id_cliente,
        CONCAT(cl.nombre_cliente, ' ', cl.apellido_paterno, ISNULL(CONCAT(' ', cl.apellido_materno), '')) AS cliente_nombre_completo,

        -- SERVICIO
        s.id_servicio,
        s.nombre_servicio,

        -- EMPLEADO
        e.id_empleado,
        CONCAT(e.nombre_empleado, ' ', e.apellido_paterno, ISNULL(CONCAT(' ', e.apellido_materno), '')) AS empleado_nombre_completo,

        -- CONTRATO
        c.fecha_contrato,
        c.estatus_contrato,
        c.estado_instalacion,
        c.monto_total,
        c.observaciones,

        -- ZONA (desde cliente)
        z.nombre_zona AS zona,

        -- SERVICIO extras
        s.tipo_servicio,
        s.velocidad_megas,
        s.costo_primer_mes,
        s.costo_regular,

        -- INSTALACION (si existe)
        i.id_instalacion,
        i.fecha_programada,
        i.fecha_realizada,
        i.estatus_instalacion AS instalacion_estatus,
        i.comentarios AS comentarios_instalacion

    FROM CONTRATO c
    INNER JOIN CLIENTE cl ON c.id_cliente = cl.id_cliente
    INNER JOIN SERVICIO s ON c.id_servicio = s.id_servicio
    LEFT JOIN EMPLEADO e ON c.id_empleado = e.id_empleado
    LEFT JOIN ZONA z ON cl.id_zona = z.id_zona
    LEFT JOIN INSTALACION i ON c.id_contrato = i.id_contrato
    ORDER BY c.id_contrato DESC
    ";

    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* Obtener contrato por id */
function obtenerContratoPorId($conn, $id) {
    $sql = "
    SELECT
        c.id_contrato,

        -- CLIENTE
        cl.id_cliente,
        CONCAT(cl.nombre_cliente, ' ', cl.apellido_paterno, ISNULL(CONCAT(' ', cl.apellido_materno), '')) AS cliente_nombre_completo,
        cl.telefono1,
        cl.telefono2,
        cl.correo_cliente,
        cl.calle,
        cl.numero,
        cl.colonia,
        cl.municipio,
        cl.codigo_postal,
        z.nombre_zona AS zona,

        -- SERVICIO
        s.id_servicio,
        s.nombre_servicio,
        s.tipo_servicio,
        s.velocidad_megas,
        s.costo_primer_mes,
        s.costo_regular,

        -- EMPLEADO
        e.id_empleado,
        CONCAT(e.nombre_empleado, ' ', e.apellido_paterno, ISNULL(CONCAT(' ', e.apellido_materno), '')) AS empleado_nombre_completo,

        -- CONTRATO
        c.fecha_contrato,
        c.estatus_contrato,
        c.estado_instalacion,
        c.monto_total,
        c.observaciones,

        -- INSTALACION
        i.id_instalacion,
        i.fecha_programada,
        i.fecha_realizada,
        i.estatus_instalacion AS instalacion_estatus,
        i.comentarios AS comentarios_instalacion

    FROM CONTRATO c
    INNER JOIN CLIENTE cl ON c.id_cliente = cl.id_cliente
    INNER JOIN SERVICIO s ON c.id_servicio = s.id_servicio
    LEFT JOIN EMPLEADO e ON c.id_empleado = e.id_empleado
    LEFT JOIN ZONA z ON cl.id_zona = z.id_zona
    LEFT JOIN INSTALACION i ON c.id_contrato = i.id_contrato
    WHERE c.id_contrato = :id
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* Agregar contrato */
function agregarContrato($conn, $data) {
    $sql = "INSERT INTO CONTRATO (id_cliente, id_servicio, id_empleado, fecha_contrato, estatus_contrato, estado_instalacion, monto_total, observaciones)
            VALUES (:id_cliente, :id_servicio, :id_empleado, :fecha_contrato, :estatus_contrato, :estado_instalacion, :monto_total, :observaciones)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id_cliente' => $data['id_cliente'],
        ':id_servicio' => $data['id_servicio'],
        ':id_empleado' => $data['id_empleado'] ?? null,
        ':fecha_contrato' => $data['fecha_contrato'] ?? null,
        ':estatus_contrato' => $data['estatus_contrato'] ?? 'Activo',
        ':estado_instalacion' => $data['estado_instalacion'] ?? 'Pendiente',
        ':monto_total' => $data['monto_total'] ?? 0,
        ':observaciones' => $data['observaciones'] ?? null
    ]);
    return $conn->lastInsertId();
}

/* Editar contrato */
function editarContrato($conn, $id, $data) {
    $sql = "UPDATE CONTRATO SET
                id_cliente = :id_cliente,
                id_servicio = :id_servicio,
                id_empleado = :id_empleado,
                fecha_contrato = :fecha_contrato,
                estatus_contrato = :estatus_contrato,
                estado_instalacion = :estado_instalacion,
                monto_total = :monto_total,
                observaciones = :observaciones
            WHERE id_contrato = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id_cliente' => $data['id_cliente'],
        ':id_servicio' => $data['id_servicio'],
        ':id_empleado' => $data['id_empleado'] ?? null,
        ':fecha_contrato' => $data['fecha_contrato'] ?? null,
        ':estatus_contrato' => $data['estatus_contrato'] ?? 'Activo',
        ':estado_instalacion' => $data['estado_instalacion'] ?? 'Pendiente',
        ':monto_total' => $data['monto_total'] ?? 0,
        ':observaciones' => $data['observaciones'] ?? null,
        ':id' => $id
    ]);
}

/* Eliminar contrato */
function eliminarContrato($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM CONTRATO WHERE id_contrato = ?");
    $stmt->execute([$id]);
}
