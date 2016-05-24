<?php
$loader = new Twig_Loader_Filesystem($options['view']['paths']);

return new Twig_Environment($loader, $options['view']['options']);
