# Cart Api

Api para gestionar un carrito de la compra de un e-commerce.

## Requisitos

- PHP >= 8.1
- Composer
- MySQL (u otro sistema de gestión de bases de datos compatible con Laravel)

## Instalación

**Clonar el repositorio:**

```bash
git clone https://github.com/karlix/api-cart.git
```

**Instalar dependencias de PHP:**

```bash
composer install
```

**Copiar el archivo de configuración:**

```bash
cp .env.example .env
```

**Generar la clave de la aplicación:**

```bash
php artisan key:generate
```

**Configurar la base de datos en el archivo `.env`:**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_la_base_de_datos
DB_USERNAME=usuario_de_la_base_de_datos
DB_PASSWORD=contraseña_de_la_base_de_datos
```

**Ejecutar las migraciones y los seeders:**

```bash
php artisan migrate --seed
```

**Iniciar el servidor de desarrollo:**

```bash
php artisan serve
```

**Acceder a la aplicación en el navegador:**

```bash
http://127.0.0.1:8000/cart
```

**Documentación de la API:**

acceder a `https://karlix.github.io/api-cart/docs/swagger.html`

**Ejecutar pruebas:**

```bash
php artisan test
```
