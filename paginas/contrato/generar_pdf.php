<?php
// paginas/contrato/generar_pdf.php
require __DIR__ . '/../../vendor/autoload.php';
include_once(__DIR__ . '/../../datos/contratoDatos.php');

use Dompdf\Dompdf;
use Dompdf\Options;

$id = $_GET['id'] ?? null;
if (!$id) { echo "No se especificó contrato."; exit; }

$ct = obtenerContratoPorId($conn, $id);
if (!$ct) { echo "Contrato no encontrado."; exit; }

// Construir HTML
$html = '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Contrato #' . htmlspecialchars($ct['id_contrato']) . '</title>
<style>
  body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color:#222; }
  .header { text-align:center; margin-bottom:20px; }
  .section { margin-bottom:10px; }
  .label { font-weight:bold; width:150px; display:inline-block; vertical-align:top; }
  .box { border:1px solid #ddd; padding:10px; border-radius:6px; margin-bottom:10px; }
  .small { font-size:11px; color:#555; }
</style>
</head>
<body>
  <div class="header">
    <h2>Contrato #' . $ct['id_contrato'] . '</h2>
    <p class="small">Fecha: ' . ($ct['fecha_contrato'] ? date('d/m/Y H:i', strtotime($ct['fecha_contrato'])) : '') . '</p>
  </div>

  <div class="box">
    <div><span class="label">Cliente:</span>' . htmlspecialchars($ct['cliente_nombre_completo'] ?? '') . '</div>
    <div><span class="label">Zona:</span>' . htmlspecialchars($ct['zona'] ?? '') . '</div>
    <div><span class="label">Dirección:</span>' . htmlspecialchars((($ct['calle'] ?? '') . ' ' . ($ct['numero'] ?? '') . ', ' . ($ct['colonia'] ?? ''))) . '</div>
  </div>

  <div class="box">
    <div><span class="label">Servicio:</span>' . htmlspecialchars($ct['nombre_servicio'] ?? '') . ' (' . htmlspecialchars($ct['tipo_servicio'] ?? '') . ')</div>
    <div><span class="label">Velocidad:</span>' . htmlspecialchars($ct['velocidad_megas'] ?? '') . ' ' . ( $ct['velocidad_megas'] ? 'Mbps' : '' ) . '</div>
    <div><span class="label">Empleado:</span>' . htmlspecialchars($ct['empleado_nombre_completo'] ?? '') . '</div>
  </div>

  <div class="box">
    <div><span class="label">Monto Total:</span>$' . number_format($ct['monto_total'] ?? 0, 2) . '</div>
    <div><span class="label">Estatus:</span>' . htmlspecialchars($ct['estatus_contrato'] ?? '') . '</div>
    <div><span class="label">Instalación:</span>' . htmlspecialchars($ct['instalacion_estatus'] ?? ($ct['estado_instalacion'] ?? '')) . '</div>
  </div>

  <div class="box">
    <strong>Observaciones:</strong>
    <div>' . nl2br(htmlspecialchars($ct['observaciones'] ?? '')) . '</div>
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
$dompdf->stream("contrato_{$ct['id_contrato']}.pdf", ["Attachment" => false]);
exit;
