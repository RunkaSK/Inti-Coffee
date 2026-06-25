# Inti-Coffee

Prroyecto PHP con base de datos SQLite local.

## Como ejecutar

```powershell
cd C:\Users\sierr\OneDrive\Escritorio\Inti-Coffee
php -S localhost:8000
```

Abre:

```text
http://localhost:8000/index.php
```

## Login

Cliente: puedes registrarte desde el modal de la pagina.

Negocio por defecto:

```text
correo: negocio@inticoffee.local
clave: negocio123
```

## Vistas

- Cliente: `menu.php`, `producto.php` y `carrito.php`.
- Negocio: `negocio.php` para crear, editar, eliminar, activar/ocultar productos y modificar stock.

## Base de datos

La base SQLite se crea automaticamente en:

```text
database/inti_coffee.db
```

El esquema esta en:

```text
database/schema.sql
```

GitHub Pages no ejecuta PHP ni SQLite. Para que login, carrito, CRUD y stock funcionen necesitas ejecutar localmente o publicar en un hosting con PHP.
