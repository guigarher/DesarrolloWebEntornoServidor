const tabla = document.getElementById("tabla");
const mensaje = document.getElementById("mensaje");
const raw = document.getElementById("raw");
const apiUrlInput = document.getElementById("apiUrl");

function setMsg(texto, ok) {
  mensaje.textContent = texto;
  mensaje.className = ok ? "ok" : "bad";
}

async function getJsonOrExplain(res) {
  try {
    return await res.json();
  } catch {
    return {
      ok: false,
      code: "NON_JSON",
      error: "Respuesta no JSON",
      httpStatus: res.status
    };
  }
}

document.getElementById("btnGet").addEventListener("click", async () => {
  const url = apiUrlInput.value.trim();
  raw.textContent = "";
  tabla.innerHTML = "";
  setMsg("Cargando...", true);

  try {
    const res = await fetch(url);
    const data = await getJsonOrExplain(res);

    raw.textContent = JSON.stringify({ httpStatus: res.status, ...data }, null, 2);

    if (!res.ok) {
      setMsg(`❌ Error HTTP ${res.status} — ${data.code ?? ""} ${data.error ?? ""}`, false);
      return;
    }

    if (!data.ok) {
      setMsg(`❌ La API respondió, pero con error: ${data.code} - ${data.error}`, false);
      return;
    }

    if (!Array.isArray(data.data) || data.data.length === 0) {
      setMsg("ℹ️ No hay productos", true);
      return;
    }

    setMsg("✅ Productos cargados", true);

    data.data.forEach((p) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${p.ID}</td>
        <td>${p.Nombre ?? ""}</td>
        <td>${p.CodigoBarras ?? ""}</td>
        <td>${p.Codigo ?? ""}</td>
        <td>${p.PVP}</td>
        <td>${p.FechaCaducidad ?? ""}</td>
        <td>${p.FechaActualizacion ?? ""}</td>
      `;
      tabla.appendChild(tr);
    });
  } catch (e) {
    setMsg("❌ No se pudo conectar (servidor caído / URL mal / CORS / red)", false);
    raw.textContent = String(e);
  }
});
