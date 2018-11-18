<?php

namespace App\Controller\Api;

use App\Response\BasicResponse;
use App\Service\RestClient\GithubClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class IssueController
 *
 * @Route("/issue")
 */
class IssueController extends AbstractController
{
    /**
     * @Route("/")
     *
     * @Method("GET")
     *
     * @param Request       $request
     * @param GithubClient  $githubClient
     * @param BasicResponse $basicResponse
     *
     * @return Response
     */
    public function list(Request $request, GithubClient $githubClient, BasicResponse $basicResponse): Response
    {
        $githubClient->setAuthorization($request->headers->get('Authorization'));

        return $this->handleResponseView($basicResponse->setData($githubClient->getIssues()));
    }

    /**
     * @Route("/{owner}/{repo}/{issueId}")
     *
     * @Method("GET")
     *
     * @param string        $owner
     * @param string        $repo
     * @param string        $issueId
     * @param Request       $request
     * @param GithubClient  $githubClient
     * @param BasicResponse $basicResponse
     *
     * @return Response
     */
    public function index(string $owner, string $repo, string $issueId, Request $request, GithubClient $githubClient, BasicResponse $basicResponse): Response
    {
        return $this->handleResponseView($basicResponse->setData($githubClient->getComments($owner, $repo, $issueId)));
    }
}
