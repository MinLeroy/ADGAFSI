<?php
// paginas/pago/pago.php
include_once(__DIR__ . "/../../datos/pagoDatos.php");

$resumen = resumenPagos($conn);
$pagos = obtenerPagos($conn);

// 🔥 Obtener pagos próximos igual que panel general
$consultaProximos = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM pago
    WHERE estatus_pago = 'Pendiente'
      AND fecha_proximo_pago BETWEEN CAST(GETDATE() AS DATE)
                                AND DATEADD(DAY, 3, CAST(GETDATE() AS DATE))
");
$consultaProximos->execute();
$pagosProximos = $consultaProximos->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['total_pagos'] ?? 0 ?></div>
        <div class="stat-label">Pagos Totales</div>
        <i class="ri-money-dollar-circle-line" style="font-size:1.8rem; color:#00bcd4;"></i>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $resumen['pendientes'] ?? 0 ?></div>
        <div class="stat-label">Pagos Pendientes</div>
        <i class="ri-time-line" style="font-size:1.8rem; color:#00bcd4;"></i>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $pagosProximos ?></div>
        <div class="stat-label">Pagos Próximos (3 días)</div>
        <i class="ri-calendar-check-line" style="font-size:1.8rem; color:#00bcd4;"></i>
    </div>
</div>

<div class="card">
  <div class="card-header"><i class="ri-file-list-3-line"></i> Pagos</div>
  <div class="card-body">
    <div class="actions mb-3">
      <a href="home.php?page=pago/agregar" class="btn btn-primary"><i class="ri-add-circle-line"></i> Nuevo Pago</a>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Cliente</th>
            <th>Monto</th>
            <th>Próximo Pago</th>
            <th>Estatus</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!empty($pagos)): ?>
          <?php foreach ($pagos as $p): ?>
            <tr>
              <td><?= htmlspecialchars($p['cliente_nombre_completo'] ?? '—') ?></td>
              <td>$<?= number_format($p['monto_pago'] ?? 0, 2) ?></td>
              <td><?= $p['fecha_proximo_pago'] ? date('d/m/Y', strtotime($p['fecha_proximo_pago'])) : '—' ?></td>
              <td><span class="badge"><?= htmlspecialchars($p['estatus_pago'] ?? '') ?></span></td>
              <td class="text-center">
                <a href="home.php?page=pago/ver&id=<?= $p['id_pago'] ?>" class="btn btn-sm btn-info" title="Ver"><i class="ri-eye-line"></i></a>
                <a href="home.php?page=pago/editar&id=<?= $p['id_pago'] ?>" class="btn btn-sm btn-warning" title="Editar"><i class="ri-edit-line"></i></a>

                <!-- imprimir PDF -->
                <form action="paginas/pago/generar_pdf.php" method="GET" style="display:inline;" target="_blank">
                  <input type="hidden" name="id" value="<?= $p['id_pago'] ?>">
                  <button type="submit" class="btn btn-sm btn-info" title="Generar PDF"><i class="ri-file-download-line"></i></button>
                </form>

                <form action="controles/pago.php" method="POST" style="display:inline;">
                  <input type="hidden" name="accion" value="eliminar">
                  <input type="hidden" name="id_pago" value="<?= $p['id_pago'] ?>">
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Eliminar pago?');"><i class="ri-delete-bin-line"></i></button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="5" class="text-center">No hay pagos.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success mt-3">
        <?php
            if ($_GET['msg'] === 'ok') echo '✅ Pago agregado correctamente.';
            elseif ($_GET['msg'] === 'editado') echo '✏️ Pago actualizado correctamente.';
            elseif ($_GET['msg'] === 'eliminado') echo '🗑️ Pago eliminado correctamente.';
        ?>
    </div>
<?php endif; ?>
