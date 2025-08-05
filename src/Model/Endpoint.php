<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class Endpoint
{
    public function __construct(
        public string $host,
        public string $id,
        public string $projectId,
        public string $branchId,
        public string $autoscalingLimitMinCu,
        public string $autoscalingLimitMaxCu,
        public string $regionId,
        public EndpointType $type,
        public EndpointState $currentState,
        public int $pendingState,
        public string $createdAt,
        public string $updatedAt,
        public string $provisioningState,
        public ?string $settings = null,
        public ?string $poolerEnabled = null,
        public ?string $poolerMode = null,
        public ?bool $disabled = null,
        public ?string $passwordlessAccess = null,
        public ?string $lastActive = null,
        public ?string $creationSource = null,
        public ?array $createdBy = null,
        public ?string $proxy = null,
        public ?bool $suspend = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            host: $data['host'],
            id: $data['id'],
            projectId: $data['project_id'],
            branchId: $data['branch_id'],
            autoscalingLimitMinCu: $data['autoscaling_limit_min_cu'],
            autoscalingLimitMaxCu: $data['autoscaling_limit_max_cu'],
            regionId: $data['region_id'],
            type: EndpointType::from($data['type']),
            currentState: EndpointState::from($data['current_state']),
            pendingState: $data['pending_state'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            provisioningState: $data['provisioning_state'],
            settings: $data['settings'] ?? null,
            poolerEnabled: $data['pooler_enabled'] ?? null,
            poolerMode: $data['pooler_mode'] ?? null,
            disabled: $data['disabled'] ?? null,
            passwordlessAccess: $data['passwordless_access'] ?? null,
            lastActive: $data['last_active'] ?? null,
            creationSource: $data['creation_source'] ?? null,
            createdBy: $data['created_by'] ?? null,
            proxy: $data['proxy'] ?? null,
            suspend: $data['suspend'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'host'                     => $this->host,
            'id'                       => $this->id,
            'project_id'               => $this->projectId,
            'branch_id'                => $this->branchId,
            'autoscaling_limit_min_cu' => $this->autoscalingLimitMinCu,
            'autoscaling_limit_max_cu' => $this->autoscalingLimitMaxCu,
            'region_id'                => $this->regionId,
            'type'                     => $this->type->value,
            'current_state'            => $this->currentState->value,
            'pending_state'            => $this->pendingState,
            'created_at'               => $this->createdAt,
            'updated_at'               => $this->updatedAt,
            'provisioning_state'       => $this->provisioningState,
            'settings'                 => $this->settings,
            'pooler_enabled'           => $this->poolerEnabled,
            'pooler_mode'              => $this->poolerMode,
            'disabled'                 => $this->disabled,
            'passwordless_access'      => $this->passwordlessAccess,
            'last_active'              => $this->lastActive,
            'creation_source'          => $this->creationSource,
            'created_by'               => $this->createdBy,
            'proxy'                    => $this->proxy,
            'suspend'                  => $this->suspend,
        ], fn ($value) => $value !== null);
    }
}
