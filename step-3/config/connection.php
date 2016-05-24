<?php
return new PDO(
    $options['db']['dsn'],
    $options['db']['username'],
    $options['db']['password'],
    $options['db']['options']
);
