<?php
$view = new Twig_Environment(
    new Twig_Loader_Filesystem($options['view']['paths']),
    $options['view']['options']
);
