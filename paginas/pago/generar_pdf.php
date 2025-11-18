<?php
// paginas/pago/generar_pdf.php
require __DIR__ . '/../../vendor/autoload.php';
include_once(__DIR__ . '/../../datos/pagoDatos.php');

use Dompdf\Dompdf;
use Dompdf\Options;

$id = $_GET['id'] ?? null;
if (!$id) { echo "No se especificó pago."; exit; }

$p = obtenerPagoPorId($conn, $id);
if (!$p) { echo "Pago no encontrado."; exit; }

$html = '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Pago #' . htmlspecialchars($p['id_pago']) . '</title>
<style>
  body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color:#222; }
  .header { text-align:center; margin-bottom:20px; }
  .label { font-weight:bold; width:150px; display:inline-block; vertical-align:top; }
  .box { border:1px solid #ddd; padding:10px; border-radius:6px; margin-bottom:10px; }
  .small { font-size:11px; color:#555; }
</style>
</head>
<body>
  <div class="header">
    <h2>Pago #' . $p['id_pago'] . '</h2>
    <p class="small">Fecha Registro: ' . ($p['fecha_pago'] ? date('d/m/Y H:i', strtotime($p['fecha_pago'])) : '') . '</p>
  </div>

  <div class="box">
    <div><span class="label">Cliente:</span>' . htmlspecialchars($p['cliente_nombre_completo'] ?? '') . '</div>
    <div><span class="label">Contrato ID:</span>' . htmlspecialchars($p['id_contrato'] ?? '') . '</div>
    <div><span class="label">Zona:</span>' . htmlspecialchars($p['zona'] ?? '') . '</div>
  </div>

  <div class="box">
    <div><span class="label">Servicio:</span>' . htmlspecialchars($p['nombre_servicio'] ?? '') . '</div>
    <div><span class="label">Monto:</span>$' . number_format($p['monto_pago'] ?? 0, 2) . '</div>
    <div><span class="label">Estatus:</span>' . htmlspecialchars($p['estatus_pago'] ?? '') . '</div>
  </div>

  <div class="box">
    <div><span class="label">Próximo Pago:</span>' . ($p['fecha_proximo_pago'] ? date('d/m/Y', strtotime($p['fecha_proximo_pago'])) : '—') . '</div>
    <div><span class="label">Ticket:</span>' . htmlspecialchars($p['ticket_pago'] ?? '') . '</div>
  </div>

  <div style="margin-top:30px;">Firma: ____________________________</div>
</body>
</html>
';

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVu Sans');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4','portrait');
$dompdf->render();
$dompdf->stream("pago_{$p['id_pago']}.pdf", ["Attachment" => false]);
exit;
