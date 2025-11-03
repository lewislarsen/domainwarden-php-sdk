<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class DomainComponents
{
    public function __construct(
        public readonly WhoisComponent $whois,
        public readonly DnsComponent $dns,
        public readonly SslComponent $ssl,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            whois: WhoisComponent::fromArray($data['whois']),
            dns: DnsComponent::fromArray($data['dns']),
            ssl: SslComponent::fromArray($data['ssl']),
        );
    }

    public function toArray(): array
    {
        return [
            'whois' => $this->whois->toArray(),
            'dns' => $this->dns->toArray(),
            'ssl' => $this->ssl->toArray(),
        ];
    }
}