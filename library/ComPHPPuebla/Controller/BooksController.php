<?php
namespace ComPHPPuebla\Controller;

use \NotORM;

class BooksController extends HttpController
{
    /** @type NotORM */
    protected $notORM;

    /**
     * @param NotORM $notORM
     */
    public function __construct(NotORM $notORM)
    {
        $this->notORM = $notORM;
    }

    /**
     * @return array
     */
    public function listAction()
    {
        return ['books' => $this->notORM->book()];
    }

    /**
     * @return array
     */
    public function showAction()
    {
        $bookId = $this->getParam('bookId');

        $book = $this->notORM
                     ->book('book_id = ?', $bookId)
                     ->fetch();

        $book['author'] = $this->notORM
                               ->author('author_id', $book['author_id'])
                               ->fetch();

        return ['book' => $book];
    }

}
