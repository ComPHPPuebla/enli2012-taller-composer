# Taller de Composer

Este taller fue creado originalmente para el ENLi 2012 y su objetivo es
ejemplificar como comenzar a usar [Composer][1] de manera gradual en un proyecto
existente.

## Instalación

Este taller consiste de 8 pasos en las que iniciamos con dos archivos que
mezclan varias responsabilidades (HTML, SQL, etc). En cada paso agregamos
componentes de librerías hasta crear un microframework MVC sencillo.

La forma mas simple de ejecutar estos ejemplos es con [Docker][1] y
[Docker compose][2]. Si los tienes instalados y configurados simplemente
ejecuta:

```bash
$ make install
$ make start 
```

El comando `make install` solo lo ejecutas la primera vez, el resto de las veces
solo necesitaras `make start`.

La pagina que debes vistar de los pasos **1** al **6** es
http://localhost:8000/list-books.php para los pasos **7** y **8** usa la pagina
http://localhost:8000/books

### Paso 1

El paso 1 consiste en dos archivos que muestran una lista de libros con links
que nos permiten ver su detalle

```bash
$ step-1
```

### Paso 2

El paso 2 integra `vlucas/phpdotenv` para separar la configuracón del código.

```bash
$ step-2
```

### Paso 3

El paso 3 integra el motor de plantillas Twig `twig/twig`.

```bash
$ step-3
```

### Paso 4

El paso 4 integra el componente `zendframework/zend-diactoros` para representar
mensajes HTTP (*Request*-*Response*).

```bash
$ step-4
```

### Paso 5

El paso 5 integra la librería `zendframework/zend-db` para el acceso a base de
datos.

```bash
$ step-5
```

### Paso 6

El paso 6 integra controladores.

```bash
$ step-6
```

### Paso 7

El paso 7 integra el router `nikic/fast-route`.

```bash
$ step-7
```

### Paso 8

El paso 8 integra el contenedor de inyección de dependencias `php-di/php-di`.

```bash
$ step-8
```

[1]: https://getcomposer.org/
[2]: https://www.docker.com/
[3]: https://docs.docker.com/compose/
