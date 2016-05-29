<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
return new PDO(
    $options['db']['dsn'],
    $options['db']['username'],
    $options['db']['password'],
    $options['db']['options']
);
