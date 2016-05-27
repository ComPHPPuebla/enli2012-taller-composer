<?php
use ComPHPPuebla\BooksCatalog\Books;
use ComPHPPuebla\BooksCatalog\ShowBooks;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

return new ShowBooks(
    new Books(
        new TableGateway(
            ['b' => 'book'],
            new Adapter($options['db']['options'])
        )
    ),
    $view
);
