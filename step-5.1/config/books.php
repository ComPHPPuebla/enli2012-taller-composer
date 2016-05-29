<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
use ComPHPPuebla\BooksCatalog\Books;
use Zend\Db\{
    Adapter\Adapter,
    TableGateway\TableGateway
};

return new Books(
    new TableGateway(['b' => 'book'], new Adapter($options['db']['options']))
);
