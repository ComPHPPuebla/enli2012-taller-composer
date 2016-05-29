<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace ComPHPPuebla\BooksCatalog;

use ArrayObject;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class Books
{
    /** @var  TableGateway */
    private $table;

    /**
     * @param TableGateway $table
     */
    public function __construct(TableGateway $table)
    {
        $this->table = $table;
    }

    /**
     * @return ResultSet
     */
    public function all(): ResultSet
    {
        return $this->table->select();
    }

    /**
     * @param int $bookId
     * @return ArrayObject
     */
    public function with(int $bookId): ArrayObject
    {
        return $this->table->select(function (Select $select) use ($bookId) {
            $select
                ->columns(['title'])
                ->join(
                    ['a' => 'author'],
                    'b.author_id = a.author_id',
                    ['author' => 'name']
                )
                ->where(['b.book_id' => $bookId])
            ;
        })->current();
    }
}
