<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace ComPHPPuebla\BooksApplication;

use Exception;
use Twig_Environment as View;
use Zend\Diactoros\Response\HtmlResponse;

class ErrorHandler
{
    /** @var View */
    private $view;

    /**
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * @param Exception $e
     * @param int $statusCode
     * @return HtmlResponse
     */
    public function handle(Exception $e, int $statusCode): HtmlResponse
    {
        error_log("Exception: \n{$e}\n");

        return new HtmlResponse(
            $this->view->render('errors/500.html.twig'),
            $statusCode
        );
    }
}
