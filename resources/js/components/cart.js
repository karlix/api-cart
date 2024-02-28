//implementar codigo para el carrito de la compra
// 1. Añadir productos al carrito
// 2. Eliminar productos del carrito
// 3. Mostrar el carrito

// classe carrito
// URL de la API

import axios from 'axios';
import Swal from 'sweetalert2';
import Mustache from 'mustache';

const CartModule = (() => {

    const apiUrl = '/api/cart';
    let cart = null;

    const getCart = async (idCart) => {
        try {
            const response = await axios.get(`${apiUrl}/${idCart}`);
            return response.data.cart;
        } catch (error) {
            console.error('Error fetching cart:', error);
            if(error.response.status === 404 || error.response.status === 400) {
                //showError("El carrito no existe, por favor recargue la pagina");
                localStorage.removeItem('idCart');
                return await createCart();
            }
        }
    };

    const showError = (message) => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
        });
    };

    const showSucces = (message) => {
        Swal.fire({
            icon: 'success',
            title: '',
            text: message,
        });
    }

    const renderCart = async (cart) => {
        try {
            // render cart items
            let htmlCartItems = '';
            for (let i in cart.items) {
                let item = cart.items[i];
                let template = document.getElementById('template-item-cart').innerHTML;
                let rendered = Mustache.render(template, {
                    priceTotal: item.priceTotal,
                    quantity: item.quantity,
                    productName: item.product.name,
                    idProduct: item.product.id,
                    productImage: item.product.image,
                });
                htmlCartItems += rendered;
            }
            document.getElementById('cart-items').innerHTML = htmlCartItems;

            //render cart details
            let template = document.getElementById('template-cart-details').innerHTML;
            let rendered = Mustache.render(template, {
                subtotal: cart.totalPrice,
                totalPrice: cart.totalPrice,
            });
            document.getElementById('cart-detail').innerHTML = rendered;

        } catch (error) {
            console.error('Error fetching cart items:', error);
        }
    };

    const addToCart = async (el) => {

        const productId = el.currentTarget.getAttribute('data-product');
        const quantity = 1; // Cantidad del producto a agregar
        const idCart = cart.id;

        try {
            const response = await axios.put(`${apiUrl}/${idCart}/add`, {
                idProduct : productId,
                quantity : quantity
            });
            console.log('Product added to cart:', response.data);
        } catch (error) {
            console.error('Error adding product to cart:', error);
        }

        await resetView();
    };

    const createCart = async () => {
        try {
            const response = await axios.post(`${apiUrl}`);
            console.log('Cart created:', response.data);

            let cart = response.data.cart;
            localStorage.setItem('idCart', cart.id);

            return cart;
        } catch (error) {
            showError("Se ha producio un error al crear el carrito, por favor recargue la pagina");
            console.error('Error creating cart:', error);
        }
    };

    const removeFromCart = async (el) => {

        const productId = el.currentTarget.getAttribute('data-product');
        const idCart = cart.id;

        try {
            const response = await axios.put(`${apiUrl}/${idCart}/remove`, {
                idProduct : productId
            });
            console.log('Product removed from cart:', response.data);
            showSucces("Producto eliminado del carrito");
            await resetView();
            // Actualizar la vista después de eliminar el producto
        } catch (error) {
            console.error('Error removing product from cart:', error);
        }
    };

    const getTotalItems = async (cart) => {
        const idCart = cart.id;
        try {
            const response = await axios.get(`${apiUrl}/${idCart}/total-products`);
            console.log('Total items in cart:', response.data);
            document.getElementById('total-items').innerHTML = response.data.totalProducts;
        } catch (error) {
            console.error('Error getting total items in cart:', error);
        }
    };

    const confirmPurchase = async () => {

        const idCart = cart.id;

        try {
            const response = await axios.put(`${apiUrl}/${idCart}/confirm`);
            console.log('Purchase confirmed:', response.data);
            showSucces("Compra confirmada correctamente");
            await resetView();
        } catch (error) {
            console.error('Error confirming purchase:', error);
        }
    };

    const incQuantity = async (el) => {

        const productId = el.currentTarget.getAttribute('data-product');
        const quantity = 1; // Cantidad del producto a agregar
        const idCart = cart.id;

        try {
            const response = await axios.put(`${apiUrl}/${idCart}/add`, {
                idProduct : productId,
                quantity : quantity
            });
            console.log('Product increment quantity product:', response.data);
        } catch (error) {
            console.error('Error increment quantity product to cart:', error);
        }

        await resetView();

    }

    const decQuantity = async (el) => {

        const productId = el.currentTarget.getAttribute('data-product');
        const quantity = 1; // Cantidad del producto a disminuir
        const idCart = cart.id;

        try {
            const response = await axios.put(`${apiUrl}/${idCart}/remove`, {
                idProduct : productId,
                quantity : quantity
            });
            console.log('Product decrement quantity product:', response.data);
        } catch (error) {
            showError("Se ha producido un error al eliminar el producto del carrito, por favor recargue la pagina");
            console.error('Error decrement quantity product from cart:', error);
        }

        await resetView();
    }

    const clearCart = async (el) => {

        const idCart = cart.id;

        try {
            const response = await axios.put(`${apiUrl}/${idCart}/clear`);
            console.log('Cart cleared:', response.data);
        } catch (error) {
            showError("Se ha producido un error al limpiar el carrito, por favor recargue la pagina");
            console.error('Error clearing cart:', error);
        }

        await resetView();
    }

    const deleteCart = async (el) => {

        const idCart = cart.id;

        try {
            const response = await axios.delete(`${apiUrl}/${idCart}`);
            console.log('Cart deleted:', response.data);
        } catch (error) {
            showError("Se ha producido un error al eliminar el carrito, por favor recargue la pagina");
            console.error('Error deleting cart:', error);
        }

        await resetView();
    }

    const resetView = async () => {
        await init();
    }

    const initEvents = async () => {
        const addToCartButton = document.getElementsByClassName('btn-add-cart');
        for(let i = 0; i < addToCartButton.length; i++) {
            addToCartButton[i].addEventListener('click', addToCart);
        }

        const removeFromCartButton = document.getElementsByClassName('btn-remove-from-cart');
        for(let i = 0; i < removeFromCartButton.length; i++) {
            removeFromCartButton[i].addEventListener('click', removeFromCart);
        }

        const clearCartButton = document.getElementsByClassName('btn-clear-cart');
        for(let i = 0; i < clearCartButton.length; i++) {
            clearCartButton[i].addEventListener('click', clearCart);
        }

        const incQuantityButton = document.getElementsByClassName('btn-inc-quantity');
        for(let i = 0; i < incQuantityButton.length; i++) {
            incQuantityButton[i].addEventListener('click', incQuantity);
        }

        const decQuantityButton = document.getElementsByClassName('btn-dec-quantity');
        for(let i = 0; i < decQuantityButton.length; i++) {
            decQuantityButton[i].addEventListener('click', decQuantity);
        }

        const confirmPurchaseButton = document.getElementById('btn-confirm-purchase');
        confirmPurchaseButton.addEventListener('click', confirmPurchase);
    }

    const init = async () => {
        try {
            let idCart = localStorage.getItem('idCart');

            if (idCart) {
                cart = await getCart(idCart);
            } else {
                cart = await createCart();
            }

            await renderCart(cart);
            await getTotalItems(cart);
            await initEvents();

            console.log('Cart:', cart);
        } catch (error) {
            console.error('Error confirming purchase:', error);
        }
    };

    return {
        init,
        getCart,
        addToCart,
        removeFromCart,
        getTotalItems,
        confirmPurchase,
        clearCart,
        deleteCart,
        createCart,
    };
})();

export default CartModule;

// hacer un duplicado de CartModule pero usando axios para las peticiones
// import axios from 'axios';

