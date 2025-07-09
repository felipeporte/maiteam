# Club de Patinaje Artístico

Este proyecto es una base para gestionar un club deportivo de patinaje artístico utilizando PHP y MySQL. Incluye un ejemplo sencillo para listar deportistas desde la base de datos.

## Requisitos

- PHP 8+
- Servidor Apache con soporte PHP
- MySQL

## Instalación

1. Clona el repositorio y copia el contenido del directorio `public` en el directorio público de tu servidor (por ejemplo, `htdocs` o `public_html`).
2. Crea una base de datos llamada `club_patinaje` y ejecuta el script `scripts/init_db.sql` para crear las tablas básicas.
3. Actualiza las credenciales de la base de datos en `config/config.php`.
4. Accede a `index.php` desde el navegador para ver la lista de deportistas.
5. Usa `add_athlete.php` para registrar nuevos deportistas.

## Generar cuotas del club

El script `scripts/generar_cuota_club.php` permite registrar de forma masiva las
cuotas mensuales para todos los apoderados. Se ejecuta desde la línea de
comandos indicando el mes a procesar en formato `AAAA-MM`:

```bash
php scripts/generar_cuota_club 2024-05
```

Si no se indica ningún argumento se utilizará el mes actual. Puedes programarlo
con `cron` para que corra cada inicio de mes, por ejemplo:

```
0 0 1 * * php /ruta/al/proyecto/scripts/generar_cuota_club.php
```
Este código es solo un punto de partida; puedes extenderlo para incluir gestión de entrenadores, pagos, rendimiento, inscripciones y un área privada para deportistas o apoderados.
