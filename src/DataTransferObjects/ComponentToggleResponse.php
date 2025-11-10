<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class ComponentToggleResponse
{
    public function __construct(
        public readonly string $message,
        public readonly string $component,
        public readonly bool $enabled,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            message: $data['message'],
            component: $data['component'],
            enabled: $data['enabled'],
        );
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'component' => $this->component,
            'enabled' => $this->enabled,
        ];
    }
}
