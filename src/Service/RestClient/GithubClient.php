<?php

namespace App\Service\RestClient;

use App\Model\Api\Login\AccessToken;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class GithubClient
 */
class GithubClient extends AbstractRestClient
{
    /**
     * @var string
     */
    private $githubUrl;
    /**
     * @var string
     */
    private $githubApiUrl;
    /**
     * @var string
     */
    private $githubClientId;
    /**
     * @var string
     */
    private $githubClientSecret;
    /**
     * @var string
     */
    private $githubState;

    /**
     * GithubClient constructor.
     *
     * @param string $githubUrl
     * @param string $githubApiUrl
     * @param string $githubClientId
     * @param string $githubClientSecret
     * @param string $githubState
     */
    public function __construct(string $githubUrl, string $githubApiUrl, string $githubClientId, string $githubClientSecret, string $githubState)
    {
        /**
         * TODO change to parameters
         */
        parent::__construct('https://api.github.com');
        $this->githubUrl = $githubUrl;
        $this->githubApiUrl = $githubApiUrl;
        $this->githubClientId = $githubClientId;
        $this->githubClientSecret = $githubClientSecret;
        $this->githubState = $githubState;
    }

    /**
     * @return string
     */
    public function getLoginUrl(): string
    {
        return $this->githubUrl.'/login/oauth/authorize?client_id='.$this->githubClientId.'&state='.'random';
    }

    /**
     * @param AccessToken $accessToken
     *
     * @return array
     */
    public function getAccessToken(AccessToken $accessToken): array
    {
        $client = $this->getClient();

        $response = $client->post($this->githubUrl.'/login/oauth/access_token?client_id='.$this->githubClientId.
            '&client_secret='.$this->githubClientSecret.'&code='.$accessToken->getCode().'&state='.$accessToken->getState());

        $response = json_decode($response->getBody()->getContents(), true);

        if (isset($response['access_token'])) {
            return $response;
        }

        throw new AccessDeniedHttpException();
    }

    /**
     * @return array
     */
    public function getIssues(): array
    {
        $client = $this->getClient();

        try {
            $response = $client->get($this->githubApiUrl.'/issues');
        } catch (ClientException $e) {
            throw new AccessDeniedHttpException();
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $owner
     * @param string $repo
     * @param string $issueId
     *
     * @return array
     */
    public function getComments(string $owner, string $repo, string $issueId): array
    {
        $client = $this->getClient();

        try {
            $response = $client->get($this->githubApiUrl.'/repos/'.$owner.'/'.$repo.'/issues/'.$issueId.'/comments');
        } catch (ClientException $e) {
            throw new AccessDeniedHttpException();
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
