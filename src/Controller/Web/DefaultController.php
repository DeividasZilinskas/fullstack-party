<?php

namespace App\Controller\Web;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 */
class DefaultController
{
    /**
     * @Route("/")
     *
     * @return Response
     */
    public function index()
    {
        return new Response('hello');
    }
}