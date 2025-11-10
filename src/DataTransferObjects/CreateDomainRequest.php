<?php

namespace Domainwarden\Sdk\DataTransferObjects;

readonly class CreateDomainRequest
{
    public function __construct(
        public string  $domain,
        public string  $label,
        public ?string $whois_check_interval = null,
        public ?string $dns_check_interval = null,
        public ?array  $enabled_dns_records = null,
        public ?string $description = null,
        public ?string $colour = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'domain' => $this->domain,
            'label' => $this->label,
        ];

        if ($this->description !== null) {
            $data['description'] = $this->description;
        }

        if ($this->colour !== null) {
            $data['colour'] = $this->colour;
        }

        if ($this->whois_check_interval !== null) {
            $data['whois_check_interval'] = $this->whois_check_interval;
        }

        if ($this->dns_check_interval !== null) {
            $data['dns_check_interval'] = $this->dns_check_interval;
        }

        if ($this->enabled_dns_records !== null) {
            $data['enabled_dns_records'] = $this->enabled_dns_records;
        }

        return $data;
    }
}