async function actualizarPanel() {
  try {
    const resp = await fetch("api/panel.php");
    const data = await resp.json();

    document.getElementById("total_clientes").textContent = data.total_clientes;
    document.getElementById("total_servicios_activos").textContent = data.total_servicios_activos;
    document.getElementById("contratos_vigentes").textContent = data.contratos_vigentes;
    document.getElementById("instalaciones_pendientes").textContent = data.instalaciones_pendientes;
    document.getElementById("pagos_proximos").textContent = data.pagos_proximos;
  } catch (err) {
    console.error("Error al actualizar el panel:", err);
  }
}

setInterval(actualizarPanel, 30000); // cada 30s
actualizarPanel();
