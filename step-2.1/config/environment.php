<?php
use Dotenv\Dotenv;

$environment = new Dotenv(__DIR__ . '/../');
$environment->load();
$environment->required(['DSN', 'USERNAME', 'PASSWORD']);
