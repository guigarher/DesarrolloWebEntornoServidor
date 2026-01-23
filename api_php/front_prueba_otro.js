function $(id){ return document.getElementById(id); }

function setEstado(msg, ok=true){
  const el = $("estado");
  el.textContent = msg;
  el.className = ok ? "ok" : "bad";
}

function apiUrl(){
  return $("apiUrl").value.trim();
}

async function request(url, options = {}){
  const res = await fetch(url, options);
  let data = null;
  try { data = await res.json(); }
  catch { data = { ok:false, error:"Respuesta no-JSON", code:"NON_JSON" }; }
  return { res, data };
}

function print(data){
  $("out").textContent = JSON.stringify(data, null, 2);
}

$("btnListar").addEventListener("click", async () => {
  setEstado("Cargando productos...");
  const { res, data } = await request(apiUrl());
  print(data);
  if (res.ok && data.ok) setEstado("✅ GET OK (listado)", true);
  else setEstado(`❌ GET falló: ${data.error ?? res.status}`, false);
});

$("btnProbarCORS").addEventListener("click", async () => {
  setEstado("Probando CORS (si esto falla, el front de otro no podrá consumir tu API)...");
  try{
    const { res, data } = await request(apiUrl());
    print(data);
    if (!res.ok) return setEstado(`❌ Respuesta no OK: ${res.status}`, false);
    setEstado("✅ CORS OK: el navegador pudo hacer fetch a tu API", true);
  }catch(e){
    setEstado("❌ Bloqueo por CORS o red (mira consola). Solución: headers CORS en la API.", false);
    console.error(e);
  }
});

$("btnCrear").addEventListener("click", async () => {
  const body = {
    Nombre: $("pNombre").value.trim(),
    PVP: parseFloat($("pPvp").value),
    CodigoBarras: $("pCB").value.trim() || null,
    Codigo: $("pCodigo").value.trim() || null,
    FechaCaducidad: $("pFecha").value.trim() || null
  };

  setEstado("Creando producto (POST)...");
  const { res, data } = await request(apiUrl(), {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(body)
  });

  print(data);
  if (res.status === 201 && data.ok) setEstado(`✅ Creado con ID ${data.id}`, true);
  else setEstado(`❌ POST falló: ${data.error ?? res.status}`, false);
});

$("btnActualizar").addEventListener("click", async () => {
  const body = {
    ID: parseInt($("uId").value, 10),
    Nombre: $("uNombre").value.trim(),
    PVP: parseFloat($("uPvp").value),
    CodigoBarras: $("uCB").value.trim() || null,
    Codigo: $("uCodigo").value.trim() || null,
    FechaCaducidad: $("uFecha").value.trim() || null
  };

  setEstado("Actualizando producto (PUT)...");
  const { res, data } = await request(apiUrl(), {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(body)
  });

  print(data);
  if (res.ok && data.ok) setEstado(`✅ Actualizado ID ${data.id}`, true);
  else setEstado(`❌ PUT falló: ${data.error ?? res.status}`, false);
});

$("btnBorrar").addEventListener("click", async () => {
  const id = parseInt($("dId").value, 10);
  if (!id) return setEstado("❌ Pon un ID válido", false);

  setEstado("Borrando producto (DELETE)...");
  const url = apiUrl() + "?id=" + encodeURIComponent(id);

  const { res, data } = await request(url, { method: "DELETE" });
  print(data);

  if (res.ok && data.ok) setEstado(`✅ Borrado ID ${data.id}`, true);
  else setEstado(`❌ DELETE falló: ${data.error ?? res.status}`, false);
});

$("btnGetId").addEventListener("click", async () => {
  const id = parseInt($("gId").value, 10);
  if (!id) return setEstado("❌ Pon un ID válido", false);

  setEstado("Cargando producto por ID...");
  const url = apiUrl() + "?id=" + encodeURIComponent(id);

  const { res, data } = await request(url);
  print(data);

  if (res.ok && data.ok) setEstado(`✅ GET OK (ID ${id})`, true);
  else setEstado(`❌ GET por ID falló: ${data.error ?? res.status}`, false);
});
