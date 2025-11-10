<?php

namespace Domainwarden\Sdk\Exceptions;

class RateLimitExceededException extends DomainwardenException
{
    public function __construct(
        string $message = 'Too many requests. Please slow down.',
        public readonly ?int $retryAfter = null
    ) {
        parent::__construct($message, 429);
    }
}
