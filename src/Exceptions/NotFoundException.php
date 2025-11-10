<?php

namespace Domainwarden\Sdk\Exceptions;

class NotFoundException extends DomainwardenException
{
    public function __construct(string $message = 'The requested resource could not be found.')
    {
        parent::__construct($message, 404);
    }
}
