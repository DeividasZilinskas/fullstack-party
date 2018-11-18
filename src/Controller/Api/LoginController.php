<?php

namespace App\Controller\Api;

use App\Form\Api\Login\AccessTokenType;
use App\Model\Api\Login\AccessToken;
use App\Response\BasicResponse;
use App\Service\RestClient\GithubClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginController
 *
 * @Route("/login")
 */
class LoginController extends AbstractController
{
    /**
     * This action return github login url
     * @Route("/")
     *
     * @Method("GET")
     *
     * @param GithubClient  $githubClient
     * @param BasicResponse $basicResponse
     *
     * @return Response
     */
    public function login(GithubClient $githubClient, BasicResponse $basicResponse): Response
    {
        $basicResponse->setData([
            'url' => $githubClient->getLoginUrl(),
        ]);

        return $this->handleResponseView($basicResponse);
    }

    /**
     * @Route("/access-token")
     *
     * @Method("POST")
     *
     * @param Request              $request
     * @param FormFactoryInterface $formFactory
     * @param GithubClient         $githubClient
     * @param BasicResponse        $basicResponse
     *
     * @return Response
     */
    public function accessToken(Request $request, FormFactoryInterface $formFactory, GithubClient $githubClient, BasicResponse $basicResponse)
    {
        $accessToken = new AccessToken();

        $form = $formFactory->create(AccessTokenType::class, $accessToken);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $basicResponse->setData($githubClient->getAccessToken($accessToken));

            return $this->handleResponseView($basicResponse);
        }

        return $this->handleView($this->view($form));
    }
}
