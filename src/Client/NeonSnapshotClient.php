<?php declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Exception\NeonApiRequestException;
use Dragonwize\NeonApiSdk\Exception\NeonApiResponseException;
use Dragonwize\NeonApiSdk\Model\NeonBranch;
use Dragonwize\NeonApiSdk\Model\NeonEndpoint;
use Dragonwize\NeonApiSdk\Model\NeonOperation;
use Dragonwize\NeonApiSdk\Model\NeonSnapshot;
use Dragonwize\NeonApiSdk\NeonApiInterface;

/**
 * Create and manage snapshots.
 */
class NeonSnapshotClient
{
    public function __construct(protected NeonApiInterface $api)
    {}

    /**
     * Create a snapshot from the specified branch using the provided parameters.
     *
     * This endpoint may initiate an asynchronous operation.
     *
     * @see https://api-docs.neon.tech/reference/createbranchsnapshot
     *
     * @param string $projectId The Neon project ID
     * @param string $branchId The branch ID
     * @param array $data Snapshot creation data
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function create(string $projectId, string $branchId, array $data = []): array
    {
        $response = $this->api->post("projects/{$projectId}/branches/{$branchId}/snapshot", $data);
        
        return $response;
    }

    /**
     * List the snapshots for the specified project.
     *
     * @see https://api-docs.neon.tech/reference/listsnapshots
     *
     * @param string $projectId The Neon project ID
     *
     * @return array<NeonSnapshot>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function list(string $projectId): array
    {
        $response = $this->api->get("projects/{$projectId}/snapshots");
        $snapshots = [];
        foreach ($response['snapshots'] as $snapshot) {
            $snapshots[] = NeonSnapshot::create($snapshot);
        }

        return $snapshots;
    }

    /**
     * Update the specified snapshot.
     *
     * @see https://api-docs.neon.tech/reference/updatesnapshot
     *
     * @param string $projectId The Neon project ID
     * @param string $snapshotId The snapshot ID
     * @param array $data Snapshot update data
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function update(string $projectId, string $snapshotId, array $data): NeonSnapshot
    {
        $response = $this->api->sendRequest('PATCH', "projects/{$projectId}/snapshots/{$snapshotId}", ['json' => ['snapshot' => $data]]);
        
        return NeonSnapshot::create($response['snapshot']);
    }

    /**
     * Delete the specified snapshot.
     *
     * @see https://api-docs.neon.tech/reference/deletesnapshot
     *
     * @param string $projectId The Neon project ID
     * @param string $snapshotId The snapshot ID
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function delete(string $projectId, string $snapshotId): NeonSnapshot
    {
        $response = $this->api->sendRequest('DELETE', "projects/{$projectId}/snapshots/{$snapshotId}");
        
        return NeonSnapshot::create($response['snapshot']);
    }

    /**
     * Restore from snapshot to a new branch.
     *
     * @see https://api-docs.neon.tech/reference/restoresnapshot
     *
     * @param string $projectId The Neon project ID
     * @param string $snapshotId The snapshot ID
     * @param array $data Restore configuration data
     *
     * @return array{branch: NeonBranch, endpoints: array<NeonEndpoint>, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function restore(string $projectId, string $snapshotId, array $data): array
    {
        $response = $this->api->post("projects/{$projectId}/snapshots/{$snapshotId}/restore", $data);
        
        $endpoints = [];
        foreach ($response['endpoints'] as $endpoint) {
            $endpoints[] = NeonEndpoint::create($endpoint);
        }
        
        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }
        
        return [
            'branch' => NeonBranch::create($response['branch']),
            'endpoints' => $endpoints,
            'operations' => $operations
        ];
    }
}