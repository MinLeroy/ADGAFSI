<?php
// paginas/pago/agregar.php
include_once(__DIR__ . "/../../datos/pagoDatos.php");

// listas
$contratos = $conn->query("SELECT c.id_contrato, CONCAT(cl.nombre_cliente, ' ', cl.apellido_paterno, ISNULL(CONCAT(' ', cl.apellido_materno),'') ) AS cliente
                           FROM CONTRATO c
                           INNER JOIN CLIENTE cl ON c.id_cliente = cl.id_cliente
                           ORDER BY c.id_contrato DESC")->fetchAll(PDO::FETCH_ASSOC);

$metodos = $conn->query("SELECT id_metodo, descripcion FROM CAT_METODO_PAGO")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
  <div class="card-header"><i class="ri-add-circle-line"></i> Nuevo Pago</div>
  <div class="card-body">
    <form action="/ADGAFSI/controles/pago.php" method="POST">
      <input type="hidden" name="accion" value="agregar">
      <div class="form-grid">
        <div class="form-group">
          <label>Contrato</label>
          <select name="id_contrato" required>
            <option value="">— Selecciona —</option>
            <?php foreach ($contratos as $c): ?>
              <option value="<?= $c['id_contrato'] ?>"><?= htmlspecialchars($c['cliente'].' (ID '.$c['id_contrato'].')') ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Fecha de Pago</label>
          <input type="datetime-local" name="fecha_pago">
        </div>

        <div class="form-group">
          <label>Monto</label>
          <input type="number" step="0.01" name="monto_pago" value="0" required>
        </div>

        <div class="form-group">
          <label>Método de Pago</label>
          <select name="id_metodo_pago">
            <option value="">— Ninguno —</option>
            <?php foreach ($metodos as $m): ?>
              <option value="<?= $m['id_metodo'] ?>"><?= htmlspecialchars($m['descripcion']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Ticket (referencia)</label>
          <input type="text" name="ticket_pago">
        </div>

        <div class="form-group">
          <label>Fecha Próximo Pago</label>
          <input type="date" name="fecha_proximo_pago" >
        </div>

        <div class="form-group">
          <label>Estatus</label>
          <select name="estatus_pago" required>
            <option value="Pendiente" selected>Pendiente</option>
            <option value="Pagado">Pagado</option>
            <option value="Cancelado">Cancelado</option>
          </select>
        </div>

        <div class="form-group full">
          <label>Observaciones (ticket / nota)</label>
          <textarea name="observaciones" rows="3"></textarea>
        </div>
      </div>

      <div class="actions">
        <button class="btn btn-success" type="submit"><i class="ri-check-line"></i> Guardar</button>
        <a href="home.php?page=pago" class="btn btn-secondary"><i class="ri-arrow-go-back-line"></i> Cancelar</a>
      </div>
    </form>
  </div>
</div>
