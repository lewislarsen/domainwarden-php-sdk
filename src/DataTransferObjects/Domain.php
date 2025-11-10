<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class Domain
{
    public function __construct(
        public readonly string $id,
        public readonly string $label,
        public readonly string $domain,
        public readonly ?string $description,
        public readonly ?string $colour,
        public readonly string $provider,
        public readonly string $expires_at,
        public readonly DomainComponents $components,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            label: $data['label'],
            domain: $data['domain'],
            description: $data['description'] ?? null,
            colour: $data['colour'] ?? null,
            provider: $data['provider'],
            expires_at: $data['expires_at'],
            components: DomainComponents::fromArray($data['components']),
            created_at: $data['created_at'],
            updated_at: $data['updated_at'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'domain' => $this->domain,
            'description' => $this->description,
            'colour' => $this->colour,
            'provider' => $this->provider,
            'expires_at' => $this->expires_at,
            'components' => $this->components->toArray(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
