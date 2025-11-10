<?php

namespace Domainwarden\Sdk\Exceptions;

class SubscriptionRequiredException extends DomainwardenException
{
    public function __construct(string $message = 'An active subscription is required to access this feature.')
    {
        parent::__construct($message, 402);
    }
}
