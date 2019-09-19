<?php

namespace AppBundle\Security;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GithubAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    private $client;
    private $clientId;
    private $clientSecret;
    private $router;

    public function __construct(Client $client, $clientId, $clientSecret, Router $router)
    {
        $this->client = $client;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->router = $router;
    }


    public function createToken(Request $request, $providerKey)
    {
        $code = $request->query->get('code');

        $redirectUri = $this->router->generate('github_redirect_url', [], ROUTER::ABSOLUTE_URL);
        $url = 'https://github.com/login/oauth/access_token?client_id='.$this->clientId.'&client_secret='.$this->clientSecret.'&code='.$code.'&redirect_uri='.urlencode($redirectUri);


        $response = $this->client->post($url, array(''));

        $res = $response->getBody()->getContents();
        $info = explode('&', $res);
        $res = explode('=', $info[0]);

        if (isset($res[0]) && 'error' == $res[0]) {
            throw new BadCredentialsException('No access_token returned by Github. Start over the process.');
        }

        return new PreAuthenticatedToken(
            'anon.',
            $res[1],
            $providerKey
        );
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        $accessToken = $token->getCredentials();

        $user = $userProvider->loadUserByUsername($accessToken);
        return new PreAuthenticatedToken(
            $user,
            $accessToken,
            $providerKey,
            ['ROLE_USER']
        );
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response("Authentication Failed :(", 403);
    }
}