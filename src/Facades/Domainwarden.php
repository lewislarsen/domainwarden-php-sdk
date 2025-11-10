<?php

namespace Domainwarden\Sdk\Facades;

use Domainwarden\Sdk\DataTransferObjects\CreateDomainRequest;
use Domainwarden\Sdk\DataTransferObjects\Domain;
use Domainwarden\Sdk\DataTransferObjects\PaginatedResponse;
use Domainwarden\Sdk\DataTransferObjects\UpdateDomainRequest;
use Domainwarden\Sdk\DataTransferObjects\User;
use Illuminate\Support\Facades\Facade;

/**
 * @method static User user()
 * @method static PaginatedResponse domains(int $page = 1)
 * @method static Domain createDomain(CreateDomainRequest $request)
 * @method static Domain getDomain(string $id)
 * @method static Domain updateDomain(string $id, UpdateDomainRequest $request)
 * @method static bool deleteDomain(string $id)
 *
 * @see \Domainwarden\Sdk\DomainwardenClient
 */
class Domainwarden extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'domainwarden';
    }
}