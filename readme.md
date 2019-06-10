## Gob MX - Gasolineras

[https://datos.gob.mx/blog/api-datosgobmx](https://datos.gob.mx/blog/api-datosgobmx)

Proyecto de ejemplo de consumo del API del Gobierno de los Estados Unidos Mexicanos para mostrar las gasolineras y el
precio de los combustibles que vende cada una.



### Servicio - Precio de gasolina al público

Ubicación geográfica de las gasolineras de la Ciudad de México y precio de venta de gasolina por litro.

* Dataset: [https://api.datos.gob.mx/v2/api-catalog?_id=5cccf090e2705c193281f178](https://api.datos.gob.mx/v2/api-catalog?_id=5cccf090e2705c193281f178)
* Url api: [https://api.datos.gob.mx/v2/precio.gasolina.publico](https://api.datos.gob.mx/v2/precio.gasolina.publico)

### Catalogo de Códigos postales

El catálogo de los códigos postales utilizado es el proporcionado por el 
[Servicio Postal de México](https://www.correosdemexico.com.mx/Paginas/Inicio.aspx)

El archivo utilizado en el ejemplo se generó el 2019-06-07.

### Frameworks utilizados

- [Laravel 5.8](https://laravel.com/docs/5.8)
- [Bootstrap 4](https://getbootstrap.com/docs/4.0)
- [Vue](https://vuejs.org/)
- [Font Awesome 5.9](https://fontawesome.com/)

### Ejecutar
 
 1. Descargar la rama _master_.
 1. Ejecutar ``composer install --no-dev``
 1. Ejecutar ``cp .env.example .env``
 1. Configurar la conexión de la base de datos.(Ver abajo)
 1. Ejecutar `` php artisan migrate --seed`` para generar las tablas y cargar los códigos postales.
 1. Ejecutar ``php artisan serve``
 
 ### Configurar base de datos
    
 El en archivo ``.env`` cambiar los datos de conexión a la base de datos
 
 ````
 DB_CONNECTION=mysql
 DB_HOST=127.0.0.1
 DB_PORT=3306
 DB_DATABASE=homestead
 DB_USERNAME=homestead
 DB_PASSWORD=secret
 ````
 
 La base de datos debe de existir previamente.


## Licencia
Software de código abierto licenciado bajo [MIT license](https://opensource.org/licenses/MIT).

