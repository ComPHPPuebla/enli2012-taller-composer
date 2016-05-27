<?php
use ComPHPPuebla\BooksCatalog\Books;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

return new Books(
    new TableGateway(['b' => 'book'], new Adapter($options['db']['options']))
);
