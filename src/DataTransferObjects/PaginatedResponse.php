<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class PaginatedResponse
{
    public function __construct(
        public readonly array $data,
        public readonly PaginationLinks $links,
        public readonly PaginationMeta $meta,
    ) {}

    public static function fromArray(array $response, callable $itemMapper): self
    {
        $data = array_map($itemMapper, $response['data'] ?? []);

        return new self(
            data: $data,
            links: PaginationLinks::fromArray($response['links'] ?? []),
            meta: PaginationMeta::fromArray($response['meta'] ?? []),
        );
    }

    public function toArray(): array
    {
        return [
            'data' => array_map(fn($item) => $item->toArray(), $this->data),
            'links' => $this->links->toArray(),
            'meta' => $this->meta->toArray(),
        ];
    }
}