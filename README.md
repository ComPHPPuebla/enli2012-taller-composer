# Taller de Composer

Este taller fue creado originalmente para el ENLi 2012 y su objetivo es
ejemplificar como comenzar a usar Composer de manera gradual en un proyecto
existente.

## Instalación

Este taller consiste de 8 pasos en las que iniciamos con dos archivos que
mezclan varias responsabilidades (HTML, SQL, etc). En cada paso agregamos
componentes de librerías hasta crear un microframework MVC sencillo.

Sigue las instrucciones para [instalar Composer][1].

Para cargar los datos de prueba en la base de datos, ejecuta (reemplaza los
valores de usuario y contraseña):

```bash
$ mysql --user=root --password="root" --default-character-set=utf8 < data/database.sql
```

### Paso 1

El paso 1 consiste en dos archivos que muestran una lista de libros con links
que nos permiten ver su detalle

```bash
$ php composer.phar create-project comphppuebla/composerws ./step1 dev-step-1-start
```

### Paso 2

El paso 2 integra `vlucas/phpdotenv` para separar la configuracón del código.

```bash
$ php composer.phar create-project comphppuebla/composerws ./step2 dev-step-2-aura-router
```

### Paso 3

El paso 3 integra el motor de plantillas Twig `twig/twig`.

```bash
$ php composer.phar create-project comphppuebla/composerws ./step4 dev-step-4-twig
```

### Paso 4

El paso 4 integra el componente `zendframework/zend-diactoros` para representar
mensajes HTTP (*Request*-*Response*).

```bash
$ php composer.phar create-project comphppuebla/composerws ./step3 dev-step-3-symfony-httpfoundation
```

### Paso 5

El paso 5 integra la librería `zendframework/zend-db` para el acceso a base de
datos.

```bash
$ php composer.phar create-project comphppuebla/composerws ./step5 dev-step-5-notorm
```

### Paso 6

El paso 6 integra controladores.

```bash
$ php composer.phar create-project comphppuebla/composerws ./step7 dev-step-7-controllers-comphppuebla
```

### Paso 7

El paso 7 integra el router `nikic/fast-route`.

```bash
$ php composer.phar create-project comphppuebla/composerws ./step8 dev-master
```

### Paso 8

El paso 8 integra el contenedor de inyección de dependencias `php-di/php-di`.

```bash
$ php composer.phar create-project comphppuebla/composerws ./step6 dev-step-6-dic-zf2
```

[1]: https://getcomposer.org/doc/00-intro.md#globally
