<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
$loader = new Twig_Loader_Filesystem($options['view']['paths']);

return new Twig_Environment($loader, $options['view']['options']);
