const API_URL = "api_productos.php";

const tabla = document.getElementById("tabla");
const mensaje = document.getElementById("mensaje");

async function cargar() {
  try {
    const res = await fetch(API_URL);
    const data = await res.json();

    if (!res.ok) {
      mensaje.textContent = "❌ " + data.error;
      return;
    }

    if (data.data.length === 0) {
      mensaje.textContent = "ℹ️ No hay productos";
      return;
    }

    mensaje.textContent = "✅ Productos cargados";
    tabla.innerHTML = "";

    data.data.forEach(p => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${p.ID}</td>
        <td>${p.Nombre}</td>
<<<<<<< HEAD
        <td>${p.CodigoBarras ?? ""}</td>
        <td>${p.Codigo ?? ""}</td>
        <td>${p.PVP}</td>
        <td>${p.FechaCaducidad ?? ""}</td>
        <td>${p.FechaActualizacion ?? ""}</td>
=======
        <td>${p.PVP}</td>
>>>>>>> 6b8c221e71a847da72796243e5846467ea50a776
      `;
      tabla.appendChild(tr);
    });

<<<<<<< HEAD

=======
>>>>>>> 6b8c221e71a847da72796243e5846467ea50a776
  } catch (e) {
    mensaje.textContent = "❌ No se pudo contactar con la API";
  }
}

cargar();
