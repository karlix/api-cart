import './bootstrap';
import CartModule from "./components/cart.js";

const cartModule = CartModule;

// Inicializar el módulo del carrito si estamos en la pagina de carrito
if (document.getElementById('cart-items')) {
    cartModule.init();
}
