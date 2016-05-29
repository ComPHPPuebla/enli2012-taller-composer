<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
$view = new Twig_Environment(
    new Twig_Loader_Filesystem($options['view']['paths']),
    $options['view']['options']
);
