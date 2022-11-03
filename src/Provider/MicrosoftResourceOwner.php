<?php namespace Trunkstar\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class MicrosoftResourceOwner implements ResourceOwnerInterface
{
    protected array $response;

    public function __construct(array $response = [])
    {
        $this->response = $response;
    }

    public function getId(): string
    {
        return $this->response['id'];
    }

    public function getEmail(): ?string
    {
        return $this->response['mail'] ?: null;
    }

    public function getFirstName(): ?string
    {
        return $this->response['givenName'] ?: null;
    }

    public function getLastName(): ?string
    {
        return $this->response['surname'] ?: null;
    }

    public function toArray(): array
    {
        return $this->response;
    }
}
