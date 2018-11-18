<?php

namespace App\Controller\Api;

use App\Response\ResponseDataInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractController
 */
abstract class AbstractController
{
    use ControllerTrait;

    /**
     * @param ViewHandlerInterface $viewhandler
     *
     * @required
     */
    public function setViewHandler(ViewHandlerInterface $viewhandler)
    {
        $this->viewhandler = $viewhandler;
    }

    /**
     * @param ResponseDataInterface $data
     * @param int                   $statusCode
     * @param array|null            $serializeGroups
     *
     * @return Response
     */
    protected function handleResponseView(ResponseDataInterface $data, $statusCode = 200, array $serializeGroups = null): Response
    {
        $view = $this->view($data->getResponseArray(), $statusCode);

        if (null != $serializeGroups) {
            $context = new Context();
            $context->setGroups($serializeGroups);
            $view->setContext($context);
        }

        return $this->handleView($view);
    }
}
