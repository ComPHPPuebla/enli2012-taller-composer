<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
use Dotenv\Dotenv;

$environment = new Dotenv(__DIR__ . '/../');
$environment->load();
$environment->required(['DATABASE', 'USERNAME', 'PASSWORD']);
