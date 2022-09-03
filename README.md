## Hotel inverdata 

## Instalacion

- Para correr el proyecto primero se debe clonar el repositorio con el comando git clone.
- Una vez se tenga el repositorio en local, se debe abrir la terminal y con el comando cd navegar hasta la raiz del repositorio.
- Ubicados en la raiz, se debe correr el comando composer install para instalar todas las dependencias. (descargar composer: https://getcomposer.org/download/ )
- Cuando todas las dependecias hayan sido instaladas, se debe generar el archivo .env para esto se debe copiar el archivo .env.example y cambiar el nombre a .env, se puede hacer con el comando cp .env.example .env
- Correr el comando php artisan key:generate
- configurar .env:
    - lo primero es configurar los parametros de conexion a la base de datos, estos son:
        DB_CONNECTION=pgsql
        DB_HOST=127.0.0.1
        DB_PORT=5432
        DB_DATABASE=
        DB_USERNAME=
        DB_PASSWORD=
    como se puede observar el parametro DB_CONNECTION debe ser psql para conectar con postgreSQL, y el parametro DB_PORT especifica el puerto el default viene siendo 5432,
    los demas parametros corresponden a la credenciales de la base de datos

    - Lo siguiente es configurar el mail driver
        MAIL_DRIVER=smtp
        MAIL_HOST=smtp.gmail.com
        MAIL_PORT=465
        MAIL_USERNAME= 
        MAIL_PASSWORD= 
        MAIL_ENCRYPTION=ssl
        MAIL_FROM_ADDRESS= address
        MAIL_FROM_NAME="${APP_NAME}"

    Se trabaja con el smtp.gmail.com para el envio de correos, se debe crear una cuenta gmail y 
    activarle el two factor authenticator en https://myaccount.google.com/u/1/security una vez activado, se debe generar una app password, este valor es el que va en el parametro MAIL_PASSWORD del .env y el usuario gmail va en el parametro MAIL_USERNAME, los demas valores se dejan como estan.

 - por ultimo, para correr el proyecto se debe ubicar en la carpeta de este y ejecutar el comando php artisan serve, y lo podra vizualizar en la url http://127.0.0.1:8000/
