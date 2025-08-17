<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonOperation implements NeonModelInterface
{
    public function __construct(
        public string $id,
        public string $projectId,
        public OperationAction $action,
        public OperationStatus $status,
        public int $failuresCount,
        public string $createdAt,
        public string $updatedAt,
        public int $totalDurationMs,
        public ?string $branchId = null,
        public ?string $endpointId = null,
        public ?string $error = null,
        public ?string $retryAt = null,
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
            projectId: $data['project_id'],
            action: OperationAction::from($data['action']),
            status: OperationStatus::from($data['status']),
            failuresCount: $data['failures_count'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            totalDurationMs: $data['total_duration_ms'],
            branchId: $data['branch_id'] ?? null,
            endpointId: $data['endpoint_id'] ?? null,
            error: $data['error'] ?? null,
            retryAt: $data['retry_at'] ?? null,
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
            'id'                => $this->id,
            'project_id'        => $this->projectId,
            'action'            => $this->action->value,
            'status'            => $this->status->value,
            'failures_count'    => $this->failuresCount,
            'created_at'        => $this->createdAt,
            'updated_at'        => $this->updatedAt,
            'total_duration_ms' => $this->totalDurationMs,
            'branch_id'         => $this->branchId,
            'endpoint_id'       => $this->endpointId,
            'error'             => $this->error,
            'retry_at'          => $this->retryAt,
        ], fn ($value) => $value !== null);
    }
}
