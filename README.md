# Taller de Composer ENLi 2012

## Instalación

Este taller consiste de 8 fases en las que iniciamos con dos archivos que mezclan varias
responsabilidades (HTML, SQL, etc) y en cada paso agregamos componentes de librerías
hasta crear un microframework MVC sencillo. Podemos instalar cada fase usando Composer.

Para instalar composer ejecuta:

	curl -s http://getcomposer.org/installer | php

### Paso 1

El paso 1 consiste en dos archivos que muestran una lista de libros con links que nos 
permiten ver su detalle

	php composer.phar create-project comphppuebla/composerws ./step1 dev-step-1-start

### Paso 2

El paso 2 integra el router de Aura

	php composer.phar create-project comphppuebla/composerws ./step2 dev-step-2-aura-router
	
### Paso 3

El paso 3 integra el componente de symfony 2 HttpFoundation

	php composer.phar create-project comphppuebla/composerws ./step3 dev-step-3-symfony-httpfoundation
	
### Paso 4

El paso 4 integra el motor de plantillas Twig

	php composer.phar create-project comphppuebla/composerws ./step4 dev-step-4-twig
	
### Paso 5

El paso 5 integra la librería NotORM para acceso a base de datos

	php composer.phar create-project comphppuebla/composerws ./step5 dev-step-5-notorm
	
### Paso 6

El paso 6 integra el contenedor de inyección de dependencia de ZF2

	php composer.phar create-project comphppuebla/composerws ./step6 dev-step-6-dic-zf2	

### Paso 7

El paso 7 integra controladores

	php composer.phar create-project comphppuebla/composerws ./step7 dev-step-7-controllers-comphppuebla

### Paso 8

El paso 8 integra un dispatcher

	php composer.phar create-project comphppuebla/composerws ./step8 dev-master