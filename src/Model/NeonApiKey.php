<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonApiKey implements NeonModelInterface
{
    public function __construct(
        public int $id,
        public ?string $name = null,
        public ?string $createdAt = null,
        public ?ApiKeyCreatorData $createdBy = null,
        public ?string $lastUsedFromAddr = null,
        public ?string $lastUsedAt = null,
    ) {}

    /**
     * Create a hydrated instance with API response data.
     *
     * @param array<string, mixed> $data
     */
    public static function create(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'] ?? null,
            createdAt: $data['created_at'],
            createdBy: isset($data['created_by']) ? ApiKeyCreatorData::create($data['created_by']) : null,
            lastUsedFromAddr: $data['last_used_from_addr'] ?? null,
            lastUsedAt: $data['last_used_at'] ?? null,
        );
    }

    /**
     * Translate model to array with API field names and values for JSON encoding.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'id'                  => $this->id,
            'name'                => $this->name,
            'created_at'          => $this->createdAt,
            'created_by'          => $this->createdBy,
            'last_used_from_addr' => $this->lastUsedFromAddr,
            'last_used_at'        => $this->lastUsedAt,
        ], fn ($value) => $value !== null);
    }
}
