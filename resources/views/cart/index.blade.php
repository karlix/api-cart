<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/88837221dd.js" crossorigin="anonymous"></script>

    @vite('resources/css/app.css')

</head>
<body class="antialiased flex justify-center">
<div class="p-4 w-full max-w-7xl min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-ighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

    <div class="flex justify-between align-bottom border-b-2 border-black mb-5">
        <div class="flex flex-initial align-bottom">
            <h1 class="text-lg font-bold">CARRITO</h1>
            <div class="box-total-items flex flex-initial items-end ml-3">
                <div id="total-items" class=""></div><span class="ml-1">Productos</span>
            </div>
        </div>
        <div class="btn-clear-cart cursor-pointer">Vaciar carrito</div>
    </div>

    <div class="flex justify-between">
        <div id="cart-items" class="w-3/4"></div>
        <div id="cart-detail" class="flex flex-col w-1/4"></div>
    </div>

    <div class="flex flex-initial align-bottom border-b-2 border-black mt-10">
    <h2 class="text-lg font-bold">Productos que te pueden interesar</h2>
    </div>
    <div class="products sm:flex sm:justify-center sm:items-center">
        @foreach($products as $product)
            <div class="product-item flex flex-col justify-center items-center p-5">
                <img src="{{ $product->image }}" alt="{{ $product->name }} image" />
                <div class='product-name'>{{ $product->name }}</div>
                <div class='price-total'>{{ $product->price }}€</div>
                <button class="btn-add-cart bg-black text-white p-2" data-product="{{ $product->id }}">Añadir</button>
            </div>
        @endforeach
    </div>

    @verbatim
    <script id="template-item-cart" type="x-tmpl-mustache">
        <div class="cart-item flex flex-column border-b-2 my-7 mr-0">
            <div class='product-image w-20' >
                <img src="{{ productImage }}" alt="{{ productName }} image" />
            </div>
            <div class="w-4/5 flex flex-col justify-between">
                <div class="flex flex-row justify-between">
                    <div class='product-name p-2'>{{ productName }}</div>
                    <div class='price-total p-2'>{{ priceTotal }}€</div>
                </div>
                <div class="flex flex-row items-center">
                     <div class='box-quantity flex flex-row border-2 border-black'>
                        <button class="btn-dec-quantity p-2 text-2xl " data-product="{{ idProduct }}">-</button>
                        <input type="text" class="text-center w-10" value="{{ quantity }}" min="1" disabled />
                        <button class="btn-inc-quantity p-2 text-xl " data-product="{{ idProduct }}">+</button>
                    </div>
                    <div class='btn-remove-from-cart p-2 cursor-pointer' data-product="{{ idProduct }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>
    </script>

    <script id="template-cart-details" type="x-tmpl-mustache">
        <div class='subtotal-box flex flex-row justify-between'>
            <div>Subtotal</div>
            <div>{{ subtotal }}</div>
        </div>
        <div class='shipping-cost flex flex-row justify-between'>
            <div>Envio</div>
            <div>GRATIS</div>
        </div>
        <div class='total-cost flex flex-row justify-between'>
            <div>Total</div>
            <div>{{ totalPrice }}</div>
        </div>
        <button id="btn-confirm-purchase" class="bg-black text-white p-3">COMPRAR</button>
    </script>

    <script id="template-products" type="x-tmpl-mustache">
        <div class="cart-details">
            <div cl>
                <div class='subtotal-box'>
                    <div>Subtotal</div>
                    <div>{{ subtotal }}</div>
                </div>
                <div class='shipping-cost'>
                    <div>Subtotal</div>
                    <div>GRATIS</div>
                </div>
                <div class='total-cost'>
                    <div>Total</div>
                    <div>{{ totalPrice }}</div>
                </div>
                <button id="btn-confirm-purchase">COMPRAR</button>
            </div>
        </div>
    </script>
    @endverbatim
    @vite(['resources/js/app.js'])
</div>
</body>
</html>
