<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Exception\NeonApiRequestException;
use Dragonwize\NeonApiSdk\Exception\NeonApiResponseException;
use Dragonwize\NeonApiSdk\Model\NeonEndpoint;
use Dragonwize\NeonApiSdk\Model\NeonOperation;
use Dragonwize\NeonApiSdk\NeonApiInterface;

/**
 * Create and manage compute endpoints in your Neon project.
 */
class NeonEndpointClient
{
    public function __construct(protected NeonApiInterface $api) {}

    /**
     * Retrieves a list of compute endpoints for the specified project.
     *
     * A compute endpoint is a Neon compute instance.
     * You can obtain a project_id by listing the projects for your Neon account.
     *
     * @see https://api-docs.neon.tech/reference/listprojectendpoints
     *
     * @param string $projectId The Neon project ID
     *
     * @return array<NeonEndpoint>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function list(string $projectId): array
    {
        $response  = $this->api->get("projects/{$projectId}/endpoints");
        $endpoints = [];
        foreach ($response['endpoints'] as $endpoint) {
            $endpoints[] = NeonEndpoint::create($endpoint);
        }

        return $endpoints;
    }

    /**
     * Retrieves information about the specified compute endpoint.
     *
     * A compute endpoint is a Neon compute instance.
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain an endpoint_id by listing your project's compute endpoints.
     * An endpoint_id has an ep- prefix.
     *
     * @see https://api-docs.neon.tech/reference/getprojectendpoint
     *
     * @param string $projectId  The Neon project ID
     * @param string $endpointId The endpoint ID
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function get(string $projectId, string $endpointId): NeonEndpoint
    {
        $response = $this->api->get("projects/{$projectId}/endpoints/{$endpointId}");

        return NeonEndpoint::create($response['endpoint']);
    }

    /**
     * Creates a compute endpoint for the specified branch.
     *
     * An endpoint is a Neon compute instance.
     * There is a maximum of one read-write compute endpoint per branch.
     * If the specified branch already has a read-write compute endpoint, the operation fails.
     * A branch can have multiple read-only compute endpoints.
     *
     * @see https://api-docs.neon.tech/reference/createprojectendpoint
     *
     * @param string               $projectId The Neon project ID
     * @param array<string, mixed> $data      Endpoint creation data (branch_id, type, etc.)
     *
     * @return array{endpoint: NeonEndpoint, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function create(string $projectId, array $data): array
    {
        $response = $this->api->post("projects/{$projectId}/endpoints", ['endpoint' => $data]);

        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }

        return [
            'endpoint'   => NeonEndpoint::create($response['endpoint']),
            'operations' => $operations,
        ];
    }

    /**
     * Updates the specified compute endpoint.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain an endpoint_id by listing your project's compute endpoints.
     * An endpoint_id has an ep- prefix.
     *
     * @see https://api-docs.neon.tech/reference/updateprojectendpoint
     *
     * @param string               $projectId  The Neon project ID
     * @param string               $endpointId The endpoint ID
     * @param array<string, mixed> $data       Endpoint update data
     *
     * @return array{endpoint: NeonEndpoint, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function update(string $projectId, string $endpointId, array $data): array
    {
        $response = $this->api->patch("projects/{$projectId}/endpoints/{$endpointId}", ['endpoint' => $data]);

        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }

        return [
            'endpoint'   => NeonEndpoint::create($response['endpoint']),
            'operations' => $operations,
        ];
    }

    /**
     * Delete the specified compute endpoint.
     *
     * A compute endpoint is a Neon compute instance.
     * Deleting a compute endpoint drops existing network connections to the compute endpoint.
     * The deletion is completed when last operation in the chain finishes successfully.
     *
     * @see https://api-docs.neon.tech/reference/deleteprojectendpoint
     *
     * @param string $projectId  The Neon project ID
     * @param string $endpointId The endpoint ID
     *
     * @return array{endpoint: NeonEndpoint, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function delete(string $projectId, string $endpointId): array
    {
        $response = $this->api->delete("projects/{$projectId}/endpoints/{$endpointId}");

        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }

        return [
            'endpoint'   => NeonEndpoint::create($response['endpoint']),
            'operations' => $operations,
        ];
    }

    /**
     * Starts a compute endpoint.
     *
     * The compute endpoint is ready to use after the last operation in chain finishes successfully.
     *
     * @see https://api-docs.neon.tech/reference/startprojectendpoint
     *
     * @param string $projectId  The Neon project ID
     * @param string $endpointId The endpoint ID
     *
     * @return array{endpoint: NeonEndpoint, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function start(string $projectId, string $endpointId): array
    {
        $response = $this->api->post("projects/{$projectId}/endpoints/{$endpointId}/start");

        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }

        return [
            'endpoint'   => NeonEndpoint::create($response['endpoint']),
            'operations' => $operations,
        ];
    }

    /**
     * Suspend the specified compute endpoint.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain an endpoint_id by listing your project's compute endpoints.
     * An endpoint_id has an ep- prefix.
     *
     * @see https://api-docs.neon.tech/reference/suspendprojectendpoint
     *
     * @param string $projectId  The Neon project ID
     * @param string $endpointId The endpoint ID
     *
     * @return array{endpoint: NeonEndpoint, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function suspend(string $projectId, string $endpointId): array
    {
        $response = $this->api->post("projects/{$projectId}/endpoints/{$endpointId}/suspend");

        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }

        return [
            'endpoint'   => NeonEndpoint::create($response['endpoint']),
            'operations' => $operations,
        ];
    }

    /**
     * Restart the specified compute endpoint: suspend immediately followed by start operations.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain an endpoint_id by listing your project's compute endpoints.
     * An endpoint_id has an ep- prefix.
     *
     * @see https://api-docs.neon.tech/reference/restartprojectendpoint
     *
     * @param string $projectId  The Neon project ID
     * @param string $endpointId The endpoint ID
     *
     * @return array{endpoint: NeonEndpoint, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function restart(string $projectId, string $endpointId): array
    {
        $response = $this->api->post("projects/{$projectId}/endpoints/{$endpointId}/restart");

        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }

        return [
            'endpoint'   => NeonEndpoint::create($response['endpoint']),
            'operations' => $operations,
        ];
    }
}
