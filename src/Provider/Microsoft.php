<?php

namespace Trunkstar\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Microsoft extends AbstractProvider
{
    public array $defaultScopes = ['User.Read'];
    protected string $urlAuthorize = 'https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize';
    protected string $urlAccessToken = 'https://login.microsoftonline.com/organizations/oauth2/v2.0/token';
    protected string $urlResourceOwnerDetails = 'https://graph.microsoft.com/v1.0/me';

    public function getBaseAuthorizationUrl(): string
    {
        return $this->urlAuthorize;
    }

    public function getBaseAccessTokenUrl(array $params): string
    {
        return $this->urlAccessToken;
    }

    protected function getDefaultScopes(): array
    {
        return $this->defaultScopes;
    }

    protected function getAuthorizationHeaders($token = null): array
    {
        return [
            'Authorization' => 'Bearer ' . $token,
        ];
    }

    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if (isset($data['error'])) {
            throw new IdentityProviderException(
                $data['error']['message'] ?? $response->getReasonPhrase(),
                $response->getStatusCode(),
                $response->getBody(),
            );
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token): ResourceOwnerInterface
    {
        return new MicrosoftResourceOwner($response);
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return $this->urlResourceOwnerDetails;
    }
}
