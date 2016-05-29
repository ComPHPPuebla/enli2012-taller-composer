<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
require __DIR__ . '/../vendor/autoload.php';

use ComPHPPuebla\BooksApplication\Application;
use Dotenv\Dotenv;
use Zend\Diactoros\ServerRequestFactory;

$environment = new Dotenv(__DIR__ . '/../');
$environment->load();
$environment->required(['DATABASE', 'USERNAME', 'PASSWORD']);

$application = new Application(require __DIR__ . '/../config/definitions.php');
$application->run(ServerRequestFactory::fromGlobals());
