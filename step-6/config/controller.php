<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
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
