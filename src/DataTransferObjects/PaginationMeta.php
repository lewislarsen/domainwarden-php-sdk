<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class PaginationMeta
{
    public function __construct(
        public readonly int $current_page,
        public readonly ?int $from,
        public readonly int $last_page,
        public readonly array $links,
        public readonly string $path,
        public readonly int $per_page,
        public readonly ?int $to,
        public readonly int $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            current_page: $data['current_page'] ?? 1,
            from: $data['from'] ?? null,
            last_page: $data['last_page'] ?? 1,
            links: $data['links'] ?? [],
            path: $data['path'] ?? '',
            per_page: $data['per_page'] ?? 15,
            to: $data['to'] ?? null,
            total: $data['total'] ?? 0,
        );
    }

    public function toArray(): array
    {
        return [
            'current_page' => $this->current_page,
            'from' => $this->from,
            'last_page' => $this->last_page,
            'links' => $this->links,
            'path' => $this->path,
            'per_page' => $this->per_page,
            'to' => $this->to,
            'total' => $this->total,
        ];
    }
}
