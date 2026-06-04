# Inti-Coffee

Proyecto PHP con base de datos SQLite local.

## Base de datos

La conexion esta en:

```text
conexion.php
```

La base SQLite local se crea/usa en:

```text
database/inti_coffee.db
```

El archivo `.db` no se sube a GitHub porque puede contener datos reales o de prueba. El esquema para recrear tablas esta en:

```text
database/schema.sql
```

## Como ejecutar localmente

Necesitas tener PHP instalado. Puedes instalar PHP directo, XAMPP o Laragon.

Luego ejecuta:

```powershell
cd C:\Users\SkareE\Inti-Coffee
php -S localhost:8000
```

Abre en el navegador:

```text
http://localhost:8000/index.php
```

## Formularios conectados

- Registro: guarda usuarios en la tabla `usuarios`.
- Login: valida usuarios desde la tabla `usuarios`.
- Contacto: guarda mensajes en la tabla `mensajes_contacto`.

## GitHub Pages

GitHub Pages publica la version estatica del sitio usando los archivos `.html`.

La version publicada en GitHub Pages sirve para ver la pagina, navegar por secciones y mostrar el diseno. GitHub Pages no ejecuta PHP ni SQLite, asi que login, registro y contacto con base de datos solo funcionan localmente o en un hosting con PHP.

URL esperada de GitHub Pages:

```text
https://runkask.github.io/Inti-Coffee/
```

Para publicar el proyecto completo funcionando con PHP necesitas un hosting con PHP, por ejemplo XAMPP local, Laragon local, InfinityFree, AwardSpace o un VPS.
