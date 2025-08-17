<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Exception\NeonApiRequestException;
use Dragonwize\NeonApiSdk\Exception\NeonApiResponseException;
use Dragonwize\NeonApiSdk\Model\NeonOperation;
use Dragonwize\NeonApiSdk\NeonApiInterface;

/**
 * View operation details for your Neon project.
 */
class NeonOperationClient
{
    public function __construct(protected NeonApiInterface $api) {}

    /**
     * Retrieves a list of operations for the specified Neon project.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * The number of operations returned can be large.
     * To paginate the response, issue an initial request with a limit value.
     * Then, add the cursor value that was returned in the response to the next request.
     * Operations older than 6 months may be deleted from our systems.
     *
     * @see https://api-docs.neon.tech/reference/listprojectoperations
     *
     * @param string      $projectId The Neon project ID
     * @param string|null $cursor    Cursor value from the previous response
     * @param int|null    $limit     Number of operations to return (1-1000)
     *
     * @return array<NeonOperation>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function list(string $projectId, ?string $cursor = null, ?int $limit = null): array
    {
        $params = [
            'cursor' => $cursor,
            'limit'  => $limit,
        ];

        $response   = $this->api->get("projects/{$projectId}/operations" . $this->api->buildQuery($params));
        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }

        return $operations;
    }

    /**
     * Retrieves details for the specified operation.
     *
     * An operation is an action performed on a Neon project resource.
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain a operation_id by listing operations for the project.
     *
     * @see https://api-docs.neon.tech/reference/getprojectoperation
     *
     * @param string $projectId   The Neon project ID
     * @param string $operationId The operation ID (UUID)
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function get(string $projectId, string $operationId): NeonOperation
    {
        $response = $this->api->get("projects/{$projectId}/operations/{$operationId}");

        return NeonOperation::create($response['operation']);
    }
}
