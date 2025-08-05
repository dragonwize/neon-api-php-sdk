<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class Project
{
    public function __construct(
        public string $id,
        public string $platformId,
        public string $regionId,
        public string $name,
        public string $provisioningState,
        public string $defaultBranchId,
        public string $createdAt,
        public string $updatedAt,
        public int $dataStorageBytesHour,
        public int $dataTransferBytes,
        public int $writtenDataBytes,
        public int $computeTimeSeconds,
        public int $activeTimeSeconds,
        public int $cpuUsedSec,
        public bool $proxyHost,
        public string $branchLogicalSizeLimit,
        public string $branchLogicalSizeLimitBytes,
        public ProjectOwnerData $owner,
        public ?string $ownerData = null,
        public ?string $parentId = null,
        public ?string $deletionProtection = null,
        public ?string $storePasswords = null,
        public ?array $settings = null,
        public ?ProjectQuota $quota = null,
        public ?string $orgId = null,
        public ?MaintenanceWindow $maintenanceStarts = null,
        public ?string $createdBy = null,
        public ?string $maintenanceStarts2 = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            platformId: $data['platform_id'],
            regionId: $data['region_id'],
            name: $data['name'],
            provisioningState: $data['provisioning_state'],
            defaultBranchId: $data['default_branch_id'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            dataStorageBytesHour: $data['data_storage_bytes_hour'],
            dataTransferBytes: $data['data_transfer_bytes'],
            writtenDataBytes: $data['written_data_bytes'],
            computeTimeSeconds: $data['compute_time_seconds'],
            activeTimeSeconds: $data['active_time_seconds'],
            cpuUsedSec: $data['cpu_used_sec'],
            proxyHost: $data['proxy_host'],
            branchLogicalSizeLimit: $data['branch_logical_size_limit'],
            branchLogicalSizeLimitBytes: $data['branch_logical_size_limit_bytes'],
            owner: ProjectOwnerData::fromArray($data['owner']),
            ownerData: $data['owner_data'] ?? null,
            parentId: $data['parent_id'] ?? null,
            deletionProtection: $data['deletion_protection'] ?? null,
            storePasswords: $data['store_passwords'] ?? null,
            settings: $data['settings'] ?? null,
            quota: isset($data['quota']) ? ProjectQuota::fromArray($data['quota']) : null,
            orgId: $data['org_id'] ?? null,
            maintenanceStarts: isset($data['maintenance_starts']) ? MaintenanceWindow::fromArray($data['maintenance_starts']) : null,
            createdBy: $data['created_by'] ?? null,
            maintenanceStarts2: $data['maintenance_starts_2'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id'                              => $this->id,
            'platform_id'                     => $this->platformId,
            'region_id'                       => $this->regionId,
            'name'                            => $this->name,
            'provisioning_state'              => $this->provisioningState,
            'default_branch_id'               => $this->defaultBranchId,
            'created_at'                      => $this->createdAt,
            'updated_at'                      => $this->updatedAt,
            'data_storage_bytes_hour'         => $this->dataStorageBytesHour,
            'data_transfer_bytes'             => $this->dataTransferBytes,
            'written_data_bytes'              => $this->writtenDataBytes,
            'compute_time_seconds'            => $this->computeTimeSeconds,
            'active_time_seconds'             => $this->activeTimeSeconds,
            'cpu_used_sec'                    => $this->cpuUsedSec,
            'proxy_host'                      => $this->proxyHost,
            'branch_logical_size_limit'       => $this->branchLogicalSizeLimit,
            'branch_logical_size_limit_bytes' => $this->branchLogicalSizeLimitBytes,
            'owner'                           => $this->owner->toArray(),
            'owner_data'                      => $this->ownerData,
            'parent_id'                       => $this->parentId,
            'deletion_protection'             => $this->deletionProtection,
            'store_passwords'                 => $this->storePasswords,
            'settings'                        => $this->settings,
            'quota'                           => $this->quota?->toArray(),
            'org_id'                          => $this->orgId,
            'maintenance_starts'              => $this->maintenanceStarts?->toArray(),
            'created_by'                      => $this->createdBy,
            'maintenance_starts_2'            => $this->maintenanceStarts2,
        ], fn ($value) => $value !== null);
    }
}
