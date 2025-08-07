const menuData = [
    { id: 1, nombre: "Arroz con Pollo", precio: 2500, imagen: "https://via.placeholder.com/150"},
    { id: 2, nombre: "Casado de Res", precio: 3000, imagen: "https://via.placeholder.com/150"},
    { id: 3, nombre: "Gallo pinto", precio: 2500, imagen: "https://via.placeholder.com/150" }
];

const CART_KEY = 'carrito_comida_casera';

function getCart() {
    return JSON.parse(localStorage.getItem(CART_KEY)) || [];
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

function addToCart(id) {
    const item = menuData.find(p => p.id === id);
    const qty = parseInt(document.getElementById(`qty-${id}`).value);

    if (!qty || qty <1) {
        alert("Debe seleccionar una cantidad válida");
        return;
    }

    let cart = getCart();
    const existing = cart.find(p => p.id === id);

    if (existing) {
        existing.cantidad += qty;
    } else {
        cart.push({ ...item, cantidad: qty });
    }

    saveCart(cart);
    alert(`${item.nombre} agregado al carrito`);
}

function renderMenu() {
    const container = document.getElementById('menu-list');
    if (!container) return;

    menuData.forEach(producto => {
        const col = document.createElement('div');
        col.className = 'col-md-4 mb-3';


        col.innerHTML = `
             <div class="card h-100">
                 <img src="${producto.imagen}" class="card-img-top" alt="${producto.nombre}">
                 <div class="card-body">
                     <h5 class="card-title">${producto.nombre}</h5>
                     <p class="card-text">Precio: ₡${producto.precio}</p>
                     <div class="d-flex justify-content-between align-items-center">
                        <input type="number" id="qty-${producto.id}" value ="1" min="1" class="form-control w-25">
                        <button class="btn btn-success" onclick="addToCart(${producto.id})">Agregar</button>
                     </div>
                 </div>
             </div>
        `;
        container.appendChild(col);
    });
}


function updateCartDisplay() {
    const cart = getCart();
    const cartItems = document.getElementById('cart-items');
    if (!cartItems) return;

    cartItems.innerHTML = '';
    cart.forEach(item => {
        const div = document.createElement('div');
        div.className = 'mb-2';
        div.innerText = `${item.nombre} x${item.cantidad} - ₡${item.precio * item.cantidad}`;
        cartItems.appendChild(div);
    });
}

function setupPedidoForm() {
    const form = document.getElementById('order-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const nombre = document.getElementById('customerName').value;
        const metodo = document.getElementById('deliveryMethod').value;
        const notas = document.getElementById('notes').value;
        const carrito = getCart();

        if (carrito.length === 0) {
            alert('Agrega productos antes de realizar pedido');
            return;
        }

        const pedido = {
            cliente: nombre,
            metodoEntrega: metodo,
            notas: notas,
            items: carrito
        };

        console.log('Pedido enviado:', pedido);
        alert('¡Pedido realizado con éxito!');

        localStorage.removeItem(CART_KEY);
        form.reset();
        updateCartDisplay();
    });
}
    

document.addEventListener('DOMContentLoaded', () => {
        renderMenu();
        updateCartDisplay();
        setupPedidoForm();
});