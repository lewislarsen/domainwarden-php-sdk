<?php

namespace Domainwarden\Sdk;

use Domainwarden\Sdk\DataTransferObjects\Domain;
use Domainwarden\Sdk\DataTransferObjects\PaginatedResponse;
use Domainwarden\Sdk\DataTransferObjects\User;
use Domainwarden\Sdk\Exceptions\DomainwardenException;
use Domainwarden\Sdk\Exceptions\RateLimitExceededException;
use Domainwarden\Sdk\Exceptions\SubscriptionRequiredException;
use Domainwarden\Sdk\Exceptions\UnauthenticatedException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class DomainwardenClient
{
    protected string $apiToken;

    protected string $apiUrl = 'https://domainwarden.app/api';

    public function __construct(string $apiToken)
    {
        $this->apiToken = $apiToken;
    }

    /**
     * @throws RateLimitExceededException
     * @throws UnauthenticatedException
     * @throws DomainwardenException
     * @throws SubscriptionRequiredException
     */
    protected function request(string $method, string $endpoint, array $data = []): Response
    {
        $response = Http::withToken($this->apiToken)
            ->$method("{$this->apiUrl}/{$endpoint}", $data);

        $this->handleErrors($response);

        return $response;
    }

    /**
     * @throws RateLimitExceededException
     * @throws UnauthenticatedException
     * @throws DomainwardenException
     * @throws SubscriptionRequiredException
     */
    protected function handleErrors(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        match ($response->status()) {
            401 => throw UnauthenticatedException::invalidToken(),
            402 => throw new SubscriptionRequiredException(
                $response->json('message', 'An active subscription is required to access this feature.')
            ),
            429 => throw new RateLimitExceededException(
                $response->json('message', 'Too many requests. Please slow down.'),
                $response->json('retry_after')
            ),
            default => throw new DomainwardenException(
                $response->json('message', 'An error occurred.'),
                $response->status()
            ),
        };
    }

    /**
     * Get the currently authenticated user's information.
     *
     * @return User
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function user(): User
    {
        $response = $this->request('get', 'user');

        return User::fromArray($response->json() ?? []);
    }

    /**
     * Get a paginated list of domains.
     *
     * @param int $page The page number to retrieve (default: 1)
     * @return PaginatedResponse
     * @throws DomainwardenException
     * @throws RateLimitExceededException
     * @throws SubscriptionRequiredException
     * @throws UnauthenticatedException
     */
    public function domains(int $page = 1): PaginatedResponse
    {
        $response = $this->request('get', "domains?page={$page}");

        return PaginatedResponse::fromArray(
            $response->json() ?? [],
            fn($item) => Domain::fromArray($item)
        );
    }
}