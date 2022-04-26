<?php

namespace App\Security;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller;

class GitHubUserProvider
{
    private $githubClient;
    private $githubId;
    private $httpClient;

    /**
     * @param $githubClient
     * @param $githubId
     * @param $httpClient
     */
    public function __construct($githubClient, $githubId, HttpClientInterface $httpClient)
    {
        $this->githubClient = $githubClient;
        $this->githubId = $githubId;
        $this->httpClient = $httpClient;
    }
    public function loadUserFromGit(string $code){
        $url= sprintf("https://github.com/login/oauth/access_token?client_id=%s&client_secret=%s&code=%s",
        $this->githubClient, $this->githubId, $code);

        $response = $this->httpClient->request('POST', $url, [

            'headers' => [
                'Accept' => "application/json"
            ]
        ]);
        $token = $response->toArray()['access_token'];
        $response = $this->httpClient->request('GET', 'https://api.github.com/user', [
            'headers' => [
                 'Authorization' => 'token ' .$token
            ]
        ]);
      $data= $response->toArray();
      return new User($data);
    }
}