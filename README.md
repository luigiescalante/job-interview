# Prueba Backend PHP
Prueba para vacante para programador BackEnd PHP
Versiones:

* Base de datos: MariaDb 11
* PHP: Versión 7.2 y Laravel Laravel Framework 7.18.0

## Requerimientos 
1.Docker

2.Docker Compose

3.Git

## Instalación 
1.Descargar el repocitorio desde GitHub

git clone git@github.com:luigiescalante/job-interview.git .

2.Ingresar a la carpeta docker y cambiar los archivos de Dockerfile 

Las lineas 9 y 10 requieren el ID del usuario Host de la maquina para crear el volumen, si no corresponde se debe de cambiar
Para ver el usuario en la maquina Host se puede usar el comando 
```bash
uid 
```
Y nos devolvera el ID del usuario de nuestro Host
```bash
uid=1000(kaiba)
```
3.Cambiar el archivo docker-compose.yml con los path de nuestro equipo. 

En la linea 10 y la linea 22 colocar la carpeta de nuestro host donde tenemos el codigo y donde tendremos las bases de datos.
```bash
volumes:
    - '/home/kaiba/Code/php-72/neology-test/:/usr/share/nginx/html'
volumes:
      - '/home/kaiba/Code/mariadb/neology-db:/var/lib/mysql'      
```
Cambiar la linea /home/kaiba/Code/php-72/neology-test/ donde trendremos el codigo

Cambiar la linea /home/kaiba/Code/mariadb/neology-db a la carpeta donde trendemos el contenedor de la base de datos

4.Ejecutar el comando docker composer desde la carpeta de docker
```bash
$ sudo docker-compose up --build  -d
```
5.Validar que los contenedores de docker esten funcionando
```bash
docker ps -a
```
6.Crear base de datos
Entramos al contenedor de neology-db y creamos la base de datos neology
```bash
$sudo docker exec -ti neology-db bash
# mysql -u root -p 
Ingresamos el password 'root'
mariadb> create database neology;
```
7.Ejecutar los siguientes comandos dentro de la carpeta de docker
```bash
$ sudo docker exec -ti neology-db composer install
$ sudo docker exec cp .env.example .env
$ sudo docker exec php artisan key:generate
$ sudo docker php artisan migrate:install
$ sudo docker php artisan migrate
$ sudo docker php artisan db:seed
```

# Validar que el servidor este activo

https://172.19.199.2/api/v1/_healtcheck

Importante: El servidor general un certificado local, en el navegador hay que darle aceptar en como "sitio no seguro"

## Datos del usuario default
```bash
Basic Auth Token: sUV9WboHWmgRXPhniGX8YbMUmMO0PPAjIQ8dbT0IfxVY6UJ4whcMLPhvDkwZ
User: admin
Password: neology
```
## PostMan

https://www.getpostman.com/collections/86fdbea474a2a442df46

## Comando Crontab log
$ sudo docker exec neology-app php artisan neology:user-log

Utilizamos el comando de crobtab -e 

### Reiniciar Contenedores
Start the docker container
```bash
docker-compose up -d
```
### Detener contenedores
```bash
docker-compose down
```
## Website
[Lesc Developer](https://lescdeveloper.com)