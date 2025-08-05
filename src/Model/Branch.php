<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class Branch
{
    public function __construct(
        public string $id,
        public string $projectId,
        public string $name,
        public string $currentState,
        public string $stateChangedAt,
        public string $creationSource,
        public bool $default,
        public bool $protected,
        public int $cpuUsedSec,
        public int $computeTimeSeconds,
        public int $activeTimeSeconds,
        public int $writtenDataBytes,
        public int $dataTransferBytes,
        public string $createdAt,
        public string $updatedAt,
        public ?string $parentId = null,
        public ?string $parentLsn = null,
        public ?string $parentTimestamp = null,
        public ?string $logicalSizeBytes = null,
        public ?string $physicalSizeBytes = null,
        public ?bool $lastResetAt = null,
        public ?string $readOnlyAt = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            projectId: $data['project_id'],
            name: $data['name'],
            currentState: $data['current_state'],
            stateChangedAt: $data['state_changed_at'],
            creationSource: $data['creation_source'],
            default: $data['default'],
            protected: $data['protected'],
            cpuUsedSec: $data['cpu_used_sec'],
            computeTimeSeconds: $data['compute_time_seconds'],
            activeTimeSeconds: $data['active_time_seconds'],
            writtenDataBytes: $data['written_data_bytes'],
            dataTransferBytes: $data['data_transfer_bytes'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            parentId: $data['parent_id'] ?? null,
            parentLsn: $data['parent_lsn'] ?? null,
            parentTimestamp: $data['parent_timestamp'] ?? null,
            logicalSizeBytes: $data['logical_size_bytes'] ?? null,
            physicalSizeBytes: $data['physical_size_bytes'] ?? null,
            lastResetAt: $data['last_reset_at'] ?? null,
            readOnlyAt: $data['read_only_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id'                   => $this->id,
            'project_id'           => $this->projectId,
            'name'                 => $this->name,
            'current_state'        => $this->currentState,
            'state_changed_at'     => $this->stateChangedAt,
            'creation_source'      => $this->creationSource,
            'default'              => $this->default,
            'protected'            => $this->protected,
            'cpu_used_sec'         => $this->cpuUsedSec,
            'compute_time_seconds' => $this->computeTimeSeconds,
            'active_time_seconds'  => $this->activeTimeSeconds,
            'written_data_bytes'   => $this->writtenDataBytes,
            'data_transfer_bytes'  => $this->dataTransferBytes,
            'created_at'           => $this->createdAt,
            'updated_at'           => $this->updatedAt,
            'parent_id'            => $this->parentId,
            'parent_lsn'           => $this->parentLsn,
            'parent_timestamp'     => $this->parentTimestamp,
            'logical_size_bytes'   => $this->logicalSizeBytes,
            'physical_size_bytes'  => $this->physicalSizeBytes,
            'last_reset_at'        => $this->lastResetAt,
            'read_only_at'         => $this->readOnlyAt,
        ], fn ($value) => $value !== null);
    }
}
