<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonRole implements NeonModelInterface
{
    public function __construct(
        public string $branchId,
        public string $name,
        public string $createdAt,
        public string $updatedAt,
        public ?string $password = null,
        public ?bool $protected = null,
    ) {}

    /**
     * Create a hydrated instance with API response data.
     *
     * @param array<string, mixed> $data
     */
    public static function create(array $data): self
    {
        return new self(
            branchId: $data['branch_id'],
            name: $data['name'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            password: $data['password'] ?? null,
            protected: $data['protected'] ?? null,
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
            'branch_id'  => $this->branchId,
            'name'       => $this->name,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'password'   => $this->password,
            'protected'  => $this->protected,
        ], fn ($value) => $value !== null);
    }
}
