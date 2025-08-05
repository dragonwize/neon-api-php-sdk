<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class Role
{
    public function __construct(
        public string $branchId,
        public string $name,
        public string $createdAt,
        public string $updatedAt,
        public ?string $password = null,
        public ?bool $protected = null,
    ) {}

    public static function fromArray(array $data): self
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

    public function toArray(): array
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
