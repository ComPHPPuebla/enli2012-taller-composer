<?php
namespace ComPHPPuebla\Controller;

class   BooksController
extends HttpController
{
    /**
     * @var NotORM
     */
    protected $notORM;

    /**
     * @param \NotORM $notORM
     */
    public function __construct(\NotORM $notORM)
    {
        $this->setNotORM($notORM);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getParam($key)
    {
        return isset($this->params[$key]) ? $this->params[$key] : null;
    }

    /**
     * @return NotORM
     */
    public function getNotORM()
    {
        return $this->notORM;
    }

    /**
     * @param NotORM $notORM
     */
    public function setNotORM(\NotORM $notORM)
    {
        $this->notORM = $notORM;
    }

    /**
     * @return array
     */
    public function listAction()
    {
        return array('books' => $this->getNotORM()->book());
    }

    /**
     * @return array
     */
    public function showAction()
    {
        $bookId = $this->getParam('bookId');
        $book = $this->getNotOrm()
                     ->book('book_id = ?', $bookId)
                     ->fetch();
        $book['author'] = $this->getNotOrm()
                             ->author('author_id', $book['author_id'])
                             ->fetch();
        return array('book' => $book);
    }

}