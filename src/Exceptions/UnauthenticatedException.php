<?php

namespace Domainwarden\Sdk\Exceptions;

class UnauthenticatedException extends DomainwardenException
{
    public function __construct(string $message = 'Unauthenticated.')
    {
        parent::__construct($message, 401);
    }

    public static function invalidToken(): self
    {
        return new self(
            'Invalid or expired Domainwarden API token. ' .
            'Please verify your DOMAINWARDEN_API_TOKEN in your .env file. ' .
            'You can generate a new token from: https://domainwarden.app/settings/api'
        );
    }
}