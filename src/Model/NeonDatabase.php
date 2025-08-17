<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonDatabase implements NeonModelInterface
{
    public function __construct(
        public int $id,
        public string $branchId,
        public string $name,
        public string $ownerName,
        public string $createdAt,
        public string $updatedAt,
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
            branchId: $data['branch_id'],
            name: $data['name'],
            ownerName: $data['owner_name'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
        );
    }

    /**
     * Translate model to array with API field names and values for JSON encoding.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id'         => $this->id,
            'branch_id'  => $this->branchId,
            'name'       => $this->name,
            'owner_name' => $this->ownerName,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
