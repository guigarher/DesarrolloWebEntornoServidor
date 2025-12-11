const API_URL = "api_productos.php";

const tbody = document.getElementById("tbody-productos");
const form = document.getElementById("form-producto");
const mensajes = document.getElementById("mensajes");
const jsonProductos = document.getElementById("json-productos");

// Cargar productos al entrar en la página
async function cargarProductos() {
  try {
    const res = await fetch(API_URL);
    if (!res.ok) {
      throw new Error("Error al cargar productos: " + res.status);
    }
    const productos = await res.json();
    pintarTabla(productos);
    if (jsonProductos) {
      jsonProductos.textContent = JSON.stringify(productos, null, 2);
    }
  } catch (err) {
    mensajes.textContent = " " + err.message;
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
    `;

    tbody.appendChild(tr);
  });
}

// Manejar el envío del formulario para crear producto
form.addEventListener("submit", async (e) => {
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
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(nuevoProducto)
    });

    const data = await res.json();

    if (!res.ok) {
      throw new Error(data.error || "Error al crear el producto");
    }

    mensajes.textContent = " " + data.mensaje;

    //recargar la tabla
    await cargarProductos();
    form.reset();

  } catch (err) {
    mensajes.textContent = " " + err.message;
  }
});

cargarProductos();
