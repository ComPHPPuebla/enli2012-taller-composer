<?php
use ComPHPPuebla\BooksTable;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

return new BooksTable(
    new TableGateway(['b' => 'book'], new Adapter($options['db']['options']))
);
