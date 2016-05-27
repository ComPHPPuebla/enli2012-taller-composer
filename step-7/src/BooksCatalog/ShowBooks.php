<?php
namespace ComPHPPuebla\BooksCatalog;

use Twig_Environment as View;
use Zend\Diactoros\Response\HtmlResponse;

class ShowBooks
{
    /** @var Books */
    private $books;

    /** @var View */
    private $view;

    /**
     * @param Books $books
     * @param View $view
     */
    public function __construct(Books $books, View $view)
    {
        $this->books = $books;
        $this->view = $view;
    }

    /**
     * @return HtmlResponse
     */
    public function viewAll()
    {
        return new HtmlResponse($this->view->render('books/list.html.twig', [
            'books' => $this->books->all(),
        ]));
    }

    /**
     * @param int $bookId
     * @return HtmlResponse
     */
    public function showDetails($bookId)
    {
        return new HtmlResponse($this->view->render('books/show.html.twig', [
            'book' => $this->books->with($bookId),
        ]));
    }
}