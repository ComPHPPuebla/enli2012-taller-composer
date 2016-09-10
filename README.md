# Taller de Composer

Este taller fue creado originalmente para el ENLi 2012 y su objetivo es
ejemplificar el uso de [Composer][1] de manera gradual en un proyecto
existente.

## Instalación

Este taller consiste de 8 pasos en las que iniciamos con dos archivos que
mezclan varias responsabilidades (HTML, SQL, etc). En cada paso agregamos
componentes de librerías hasta crear un microframework MVC sencillo.

La forma más simple de ejecutar estos ejemplos es con [Docker][1] y
[Docker compose][2]. Si los tienes instalados y configurados simplemente
ejecuta:

```bash
$ make env
```

Esto creará un archivo `env.sh`, remplaza el valor de la variable `GITHUB_TOKEN`
por un [token válido][6]. Luego ejecuta:

```bash
$ make install
```

Este comando sólo lo ejecutas la primera vez, el resto de las veces  solo 
necesitarás:

```bash
$ source .alias
```

La página que debes vistar de los pasos **1** al **6** es
[http://localhost:8000/list-books.php][4] para los pasos **7** y **8** usa la
página [http://localhost:8000/books][5]

### Paso 1

El paso 1 consiste en dos archivos que muestran una lista de libros con links
que nos permiten ver sus detalles.

```bash
$ step1
```

### Paso 2

El paso 2 integra `vlucas/phpdotenv` para separar la configuración del código.

```bash
$ composer2 # Este sólo es necesario la primera vez
$ step2
```

### Paso 3

El paso 3 integra el motor de plantillas Twig `twig/twig`.

```bash
$ composer3 # Este sólo es necesario la primera vez
$ step3
```

### Paso 4

El paso 4 integra el componente `zendframework/zend-diactoros` para representar
mensajes HTTP (*Request*-*Response*).

```bash
$ composer4 # Este sólo es necesario la primera vez
$ step4
```

### Paso 5

El paso 5 integra la librería `zendframework/zend-db` para el acceso a base de
datos.

```bash
$ composer5 # Este sólo es necesario la primera vez
$ step5
```

### Paso 6

El paso 6 integra controladores.

```bash
$ composer6 # Este sólo es necesario la primera vez
$ step6
```

### Paso 7

El paso 7 integra el router `nikic/fast-route`.

```bash
$ composer7 # Este sólo es necesario la primera vez
$ step7
```

### Paso 8

El paso 8 integra el contenedor de inyección de dependencias `php-di/php-di`.

```bash
$ composer8 # Este sólo es necesario la primera vez
$ step8
```

[1]: https://getcomposer.org/
[2]: https://www.docker.com/
[3]: https://docs.docker.com/compose/
[4]: http://localhost:8000/list-books.php
[5]: http://localhost:8000/books
[6]: https://github.com/settings/tokens
