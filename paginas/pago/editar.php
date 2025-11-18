<?php
// paginas/pago/editar.php
include_once(__DIR__ . "/../../datos/pagoDatos.php");
$id = $_GET['id'] ?? null;
if (!$id) { echo "<div class='message error'>No especificado.</div>"; exit; }
$p = obtenerPagoPorId($conn, $id);
if (!$p) { echo "<div class='message error'>No encontrado.</div>"; exit; }

$contratos = $conn->query("SELECT c.id_contrato, CONCAT(cl.nombre_cliente, ' ', cl.apellido_paterno, ISNULL(CONCAT(' ', cl.apellido_materno),'') ) AS cliente
                           FROM CONTRATO c
                           INNER JOIN CLIENTE cl ON c.id_cliente = cl.id_cliente
                           ORDER BY c.id_contrato DESC")->fetchAll(PDO::FETCH_ASSOC);

$metodos = $conn->query("SELECT id_metodo, descripcion FROM CAT_METODO_PAGO")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
  <div class="card-header"><i class="ri-edit-2-line"></i> Editar Pago #<?= $p['id_pago'] ?></div>
  <div class="card-body">
    <form action="/ADGAFSI/controles/pago.php" method="POST">
      <input type="hidden" name="accion" value="editar">
      <input type="hidden" name="id_pago" value="<?= $p['id_pago'] ?>">
      <div class="form-grid">
        <div class="form-group">
          <label>Contrato</label>
          <select name="id_contrato" required>
            <?php foreach ($contratos as $c): ?>
              <option value="<?= $c['id_contrato'] ?>" <?= ($p['id_contrato'] == $c['id_contrato']) ? 'selected' : '' ?>><?= htmlspecialchars($c['cliente'].' (ID '.$c['id_contrato'].')') ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Fecha de Pago</label>
          <input type="datetime-local" name="fecha_pago" value="<?= $p['fecha_pago'] ? date('Y-m-d\TH:i', strtotime($p['fecha_pago'])) : '' ?>">
        </div>

        <div class="form-group">
          <label>Monto</label>
          <input type="number" step="0.01" name="monto_pago" value="<?= htmlspecialchars($p['monto_pago'] ?? 0) ?>" required>
        </div>

        <div class="form-group">
          <label>Método de Pago</label>
          <select name="id_metodo_pago">
            <option value="">— Ninguno —</option>
            <?php foreach ($metodos as $m): ?>
              <option value="<?= $m['id_metodo'] ?>" <?= ($p['id_metodo_pago'] == $m['id_metodo']) ? 'selected' : '' ?>><?= htmlspecialchars($m['descripcion']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Ticket (referencia)</label>
          <input type="text" name="ticket_pago" value="<?= htmlspecialchars($p['ticket_pago'] ?? '') ?>">
        </div>

        <div class="form-group">
          <label>Fecha Próximo Pago</label>
          <input type="date" name="fecha_proximo_pago" value="<?= $p['fecha_proximo_pago'] ? date('Y-m-d', strtotime($p['fecha_proximo_pago'])) : '' ?>">
        </div>

        <div class="form-group">
          <label>Estatus</label>
          <select name="estatus_pago" required>
            <option value="Pendiente" <?= ($p['estatus_pago']=='Pendiente')?'selected':'' ?>>Pendiente</option>
            <option value="Pagado" <?= ($p['estatus_pago']=='Pagado')?'selected':'' ?>>Pagado</option>
            <option value="Cancelado" <?= ($p['estatus_pago']=='Cancelado')?'selected':'' ?>>Cancelado</option>
          </select>
        </div>
      </div>

      <div class="actions">
        <button class="btn btn-primary" type="submit"><i class="ri-save-3-line"></i> Guardar Cambios</button>
        <a href="home.php?page=pago" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
      </div>
    </form>
  </div>
</div>
