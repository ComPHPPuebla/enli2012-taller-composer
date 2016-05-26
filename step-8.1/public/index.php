<?php
require __DIR__ . '/../vendor/autoload.php';

use ComPHPPuebla\Application;
use Dotenv\Dotenv;
use Zend\Diactoros\ServerRequestFactory;

$environment = new Dotenv(__DIR__ . '/../');
$environment->load();
$environment->required(['DATABASE', 'USERNAME', 'PASSWORD']);

$application = new Application(require __DIR__ . '/../config/definitions.php');
$application->run(ServerRequestFactory::fromGlobals());
