<?php
use ComPHPPuebla\BooksTable;
use ComPHPPuebla\ShowBooks;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

return new ShowBooks(
    new BooksTable(
        new TableGateway(
            ['b' => 'book'],
            new Adapter($options['db']['options'])
        )
    ),
    new Twig_Environment(
        new Twig_Loader_Filesystem($options['view']['paths']),
        $options['view']['options']
    )
);
