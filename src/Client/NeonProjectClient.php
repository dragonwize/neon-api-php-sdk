<?php declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Model\NeonProject;

class NeonProjectClient
{
    public function __construct(protected NeonApi $api)
    {}

    public function list(
        int $limit = 10,
        ?string $cursor = null,
        ?string $searchQuery = null,
        ?string $orgId = null,
        ?int $timeout = null
    ): array
    {
        $params = [
            'cursor'  => $cursor,
            'limit'   => $limit,
            'search'  => $searchQuery,
            'org_id'  => $orgId,
            'timeout' => $timeout,
        ];
        $request = $this->api->createRequest('GET', 'projects' . $this->api->buildQuery($params));

        return $this->api->sendRequest($request);
    }

    public function listShared(
        int     $limit = 10,
        ?string $cursor = null,
        ?string $searchQuery = null,
        ?int    $timeout = null
    ): array {
        $params  = [
            'cursor'  => $cursor,
            'limit'   => $limit,
            'search'  => $searchQuery,
            'timeout' => $timeout,
        ];
        $request = $this->api->createRequest('GET', 'projects/shared' . $this->api->buildQuery($params));

        return $this->api->sendRequest($request);
    }

    public function get(string $projectId): ?NeonProject
    {
        $request = $this->api->createRequest('GET', 'projects/' . $projectId);
        $response = $this->api->sendRequest($request);
        $responseContent = $this->api->parseResponse($response);

        return isset($responseContent['project']['id']) ? NeonProject::fromArray($responseContent['project']) : null;
    }

    public function createProject(array $data): NeonProject
    {
        $response = $this->api->sendRequest('POST', 'projects', ['json' => $data]);

        return NeonProject::fromArray($response['project']);
    }

    public function updateProject(string $projectId, array $data): NeonProject
    {
        $response = $this->api->sendRequest('PATCH', "projects/{$projectId}", ['json' => $data]);

        return NeonProject::fromArray($response['project']);
    }

    public function deleteProject(string $projectId): NeonProject
    {
        $response = $this->api->sendRequest('DELETE', "projects/{$projectId}");

        return NeonProject::fromArray($response['project']);
    }
}
