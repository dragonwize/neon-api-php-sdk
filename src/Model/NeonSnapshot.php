<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonSnapshot implements NeonModelInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $createdAt,
        public ?string $lsn = null,
        public ?string $timestamp = null,
        public ?string $sourceBranchId = null,
        public ?string $expiresAt = null,
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
            name: $data['name'],
            createdAt: $data['created_at'],
            lsn: $data['lsn'] ?? null,
            timestamp: $data['timestamp'] ?? null,
            sourceBranchId: $data['source_branch_id'] ?? null,
            expiresAt: $data['expires_at'] ?? null,
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
            'id'               => $this->id,
            'name'             => $this->name,
            'created_at'       => $this->createdAt,
            'lsn'              => $this->lsn,
            'timestamp'        => $this->timestamp,
            'source_branch_id' => $this->sourceBranchId,
            'expires_at'       => $this->expiresAt,
        ], fn ($value) => $value !== null);
    }
}
