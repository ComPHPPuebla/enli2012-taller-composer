<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
use ComPHPPuebla\BooksCatalog\{Books, ShowBooks};
use Zend\Db\{
    Adapter\Adapter,
    TableGateway\TableGateway
};

return new ShowBooks(
    new Books(
        new TableGateway(
            ['b' => 'book'],
            new Adapter($options['db']['options'])
        )
    ),
    $view
);
