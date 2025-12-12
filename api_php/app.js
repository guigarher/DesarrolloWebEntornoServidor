const API_URL = "api_productos.php";
/*https://localhost/api_php/api_productos.php*/

const tbody         = document.getElementById("tbody-productos");
const formCrear     = document.getElementById("form-producto");
const formEditar    = document.getElementById("form-editar");
const formBorrar    = document.getElementById("form-borrar");
const mensajes      = document.getElementById("mensajes");
const jsonProductos = document.getElementById("json-productos");

// ---------- GET ----------
async function cargarProductos() {
  try {
    const res = await fetch(API_URL);
    if (!res.ok) throw new Error("Error al cargar productos: " + res.status);

    const productos = await res.json();

    pintarTabla(productos);

  } catch (err) {
    mensajes.textContent = "❌ " + err.message;
  }
}

function pintarTabla(productos) {
  tbody.innerHTML = "";
  productos.forEach(p => {
    const tr = document.createElement("tr");

    tr.innerHTML = `
      <td>${p.ID}</td>
      <td>${p.Nombre}</td>
      <td>${p.CodigoBarras ?? ""}</td>
      <td>${p.Codigo ?? ""}</td>
      <td>${p.PVP}</td>
      <td>${p.FechaCaducidad ?? ""}</td>
      <td>${p.FechaActualizacion ?? ""}</td>
      <td>
        <button data-action="editar" data-id="${p.ID}">Editar</button>
        <button data-action="borrar" data-id="${p.ID}">Borrar</button>
      </td>
    `;

    tbody.appendChild(tr);
  });
}

// Botones rápidos en la tabla (rellenan formularios)
tbody.addEventListener("click", (e) => {
  const btn = e.target.closest("button");
  if (!btn) return;

  const action = btn.dataset.action;
  const id = btn.dataset.id;

  if (action === "editar") {
    document.getElementById("editId").value = id;
    mensajes.textContent = `🟡 Listo para editar ID ${id} (rellena campos y pulsa Actualizar)`;
  }

  if (action === "borrar") {
    document.getElementById("deleteId").value = id;
    mensajes.textContent = `🟠 Listo para borrar ID ${id} (pulsa Eliminar)`;
  }
});

// ---------- POST ----------
formCrear.addEventListener("submit", async (e) => {
  e.preventDefault();

  const nuevoProducto = {
    Nombre: document.getElementById("nombre").value,
    CodigoBarras: document.getElementById("codigoBarras").value || null,
    Codigo: document.getElementById("codigo").value || null,
    PVP: parseFloat(document.getElementById("pvp").value),
    FechaCaducidad: document.getElementById("fechaCaducidad").value || null,
  };

  try {
    const res = await fetch(API_URL, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(nuevoProducto)
    });

    const data = await res.json();
    if (!res.ok) throw new Error(data.error || "Error al crear el producto");

    mensajes.textContent = "✅ " + data.mensaje;

    await cargarProductos();
    formCrear.reset();

  } catch (err) {
    mensajes.textContent = "❌ " + err.message;
  }
});

// ---------- PUT ----------
formEditar.addEventListener("submit", async (e) => {
  e.preventDefault();

  const id = parseInt(document.getElementById("editId").value, 10);

  // Enviamos SOLO lo que el usuario haya escrito (si está vacío, no se manda)
  const body = {};
  const nombre = document.getElementById("editNombre").value.trim();
  const pvpStr = document.getElementById("editPvp").value;

  if (nombre !== "") body.Nombre = nombre;
  if (pvpStr !== "") body.PVP = parseFloat(pvpStr);

  try {
    const res = await fetch(`${API_URL}?id=${id}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(body)
    });

    const data = await res.json();
    if (!res.ok) throw new Error(data.error || "Error al actualizar");

    mensajes.textContent = "✅ " + data.mensaje;

    await cargarProductos();
    formEditar.reset();

  } catch (err) {
    mensajes.textContent = "❌ " + err.message;
  }
});

// ---------- DELETE ----------
formBorrar.addEventListener("submit", async (e) => {
  e.preventDefault();

  const id = parseInt(document.getElementById("deleteId").value, 10);

  try {
    const res = await fetch(`${API_URL}?id=${id}`, {
      method: "DELETE"
    });

    const data = await res.json();
    if (!res.ok) throw new Error(data.error || "Error al eliminar");

    mensajes.textContent = "✅ " + data.mensaje;

    await cargarProductos();
    formBorrar.reset();

  } catch (err) {
    mensajes.textContent = "❌ " + err.message;
  }
});

// Carga inicial
cargarProductos();
