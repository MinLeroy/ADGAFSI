async function actualizarPanel() {
  try {
    const resp = await fetch("api/panel.php");
    const data = await resp.json();

    if (data.error) {
      console.error("Error SQL:", data.error);
      return;
    }

    document.getElementById("total_clientes").textContent = data.total_clientes ?? 0;
    document.getElementById("total_servicios_activos").textContent = data.total_servicios_activos ?? 0;
    document.getElementById("contratos_vigentes").textContent = data.contratos_vigentes ?? 0;
    document.getElementById("instalaciones_pendientes").textContent = data.instalaciones_pendientes ?? 0;
    document.getElementById("pagos_proximos").textContent = data.pagos_proximos ?? 0;

  } catch (err) {
    console.error("Error al actualizar el panel:", err);
  }
}

setInterval(actualizarPanel, 30000);
actualizarPanel();
