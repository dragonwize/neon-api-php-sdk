<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonProject implements NeonModelInterface
{
    public function __construct(
        public string $id,
        public ?string $platformId = null,
        public ?string $regionId = null,
        public ?string $name = null,
        public ?string $provisioningState = null,
        public ?string $defaultBranchId = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
        public ?int $dataStorageBytesHour = null,
        public ?int $dataTransferBytes = null,
        public ?int $writtenDataBytes = null,
        public ?int $computeTimeSeconds = null,
        public ?int $activeTimeSeconds = null,
        public ?int $cpuUsedSec = null,
        public ?bool $proxyHost = null,
        public ?string $branchLogicalSizeLimit = null,
        public ?string $branchLogicalSizeLimitBytes = null,
        public ?ProjectOwnerData $owner = null,
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

    /**
     * Create a hydrated instance with API response data.
     *
     * @param array<string, string|int|bool|object|array|null> $data
     *
     * @return static
     */
    public static function create(array $data): static
    {
        return new static(
            id: $data['id'],
            platformId: $data['platform_id'] ?? null,
            regionId: $data['region_id'] ?? null,
            name: $data['name'] ?? null,
            provisioningState: $data['provisioning_state'] ?? null,
            defaultBranchId: $data['default_branch_id'] ?? null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
            dataStorageBytesHour: $data['data_storage_bytes_hour'] ?? null,
            dataTransferBytes: $data['data_transfer_bytes'] ?? null,
            writtenDataBytes: $data['written_data_bytes'] ?? null,
            computeTimeSeconds: $data['compute_time_seconds'] ?? null,
            activeTimeSeconds: $data['active_time_seconds'] ?? null,
            cpuUsedSec: $data['cpu_used_sec'] ?? null,
            proxyHost: $data['proxy_host'] ?? null,
            branchLogicalSizeLimit: $data['branch_logical_size_limit'] ?? null,
            branchLogicalSizeLimitBytes: $data['branch_logical_size_limit_bytes'] ?? null,
            owner: ProjectOwnerData::create($data['owner']) ?? null,
            ownerData: $data['owner_data'] ?? null,
            parentId: $data['parent_id'] ?? null,
            deletionProtection: $data['deletion_protection'] ?? null,
            storePasswords: $data['store_passwords'] ?? null,
            settings: $data['settings'] ?? null,
            quota: isset($data['quota']) ? ProjectQuota::create($data['quota']) : null,
            orgId: $data['org_id'] ?? null,
            maintenanceStarts: isset($data['maintenance_starts']) ? MaintenanceWindow::create($data['maintenance_starts']) : null,
            createdBy: $data['created_by'] ?? null,
            maintenanceStarts2: $data['maintenance_starts_2'] ?? null,
        );
    }

    /**
     * Translate model to array with API field names and values for JSON encoding.
     *
     * @return array<string, string|int|bool|object|array|null>
     */
    public function jsonSerialize(): array
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
            'owner'                           => $this->owner->jsonSerialize(),
            'owner_data'                      => $this->ownerData,
            'parent_id'                       => $this->parentId,
            'deletion_protection'             => $this->deletionProtection,
            'store_passwords'                 => $this->storePasswords,
            'settings'                        => $this->settings,
            'quota'                           => $this->quota?->jsonSerialize(),
            'org_id'                          => $this->orgId,
            'maintenance_starts'              => $this->maintenanceStarts?->jsonSerialize(),
            'created_by'                      => $this->createdBy,
            'maintenance_starts_2'            => $this->maintenanceStarts2,
        ], fn ($value) => $value !== null);
    }
}
