<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Exception\NeonApiException;
use Dragonwize\NeonApiSdk\Model\Branch;
use Dragonwize\NeonApiSdk\Model\Database;
use Dragonwize\NeonApiSdk\Model\Endpoint;
use Dragonwize\NeonApiSdk\Model\Operation;
use Dragonwize\NeonApiSdk\Model\Project;
use Dragonwize\NeonApiSdk\Model\Role;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class NeonApi
{
    public const string DEFAULT_BASE_URL = 'https://console.neon.tech/api/v2/';
    public const string VERSION          = '1.0.0';

    public function __construct(
        protected string $apiKey,
        protected ClientInterface $httpClient,
        protected string $baseUrl = self::DEFAULT_BASE_URL,
        protected ?LoggerInterface $logger = null,
    ) {}

    protected function getHttpClient(): ClientInterface
    {
        return $this->httpClient;

        // Example Guzzle Client.
        // new GuzzleClient([
        //     'base_uri' => $this->baseUrl,
        //     'timeout'  => 30,
        //     'headers'  => [
        //         'Authorization' => 'Bearer ' . $this->apiKey,
        //         'Accept'        => 'application/json',
        //         'Content-Type'  => 'application/json',
        //         'User-Agent'    => 'neon-client/php version=(' . self::VERSION . ')',
        //     ],
        // ]);
    }

    protected function makeRequest(string $method, string $path, array $options = []): array
    {
        try {
            $response = $this->getHttpClient()->request($method, $path, $options);

            return $this->parseResponse($response);
        } catch (RequestException $e) {
            throw new NeonApiException($e->getMessage(), $e->getCode(), $e);
        }
    }

    protected function parseResponse(ResponseInterface $response): array
    {
        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);

        if (json_last_error() !== \JSON_ERROR_NONE) {
            throw new NeonApiException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $data;
    }

    protected function compactArray(array $data): array
    {
        return array_filter($data, fn ($value) => $value !== null);
    }

    public function me(): array
    {
        return $this->makeRequest('GET', 'users/me');
    }

    public function apiKeys(): array
    {
        return $this->makeRequest('GET', 'api_keys');
    }

    public function createApiKey(array $data): array
    {
        return $this->makeRequest('POST', 'api_keys', ['json' => $data]);
    }

    public function revokeApiKey(string $apiKeyId): array
    {
        return $this->makeRequest('DELETE', "api_keys/{$apiKeyId}");
    }

    public function projects(bool $shared = false, ?string $cursor = null, ?int $limit = null): array
    {
        $path   = $shared ? 'projects/shared' : 'projects';
        $params = $this->compactArray(['cursor' => $cursor, 'limit' => $limit]);

        return $this->makeRequest('GET', $path, ['query' => $params]);
    }

    public function project(string $projectId): Project
    {
        $data = $this->makeRequest('GET', "projects/{$projectId}");

        return Project::fromArray($data['project']);
    }

    public function createProject(array $data): Project
    {
        $response = $this->makeRequest('POST', 'projects', ['json' => $data]);

        return Project::fromArray($response['project']);
    }

    public function updateProject(string $projectId, array $data): Project
    {
        $response = $this->makeRequest('PATCH', "projects/{$projectId}", ['json' => $data]);

        return Project::fromArray($response['project']);
    }

    public function deleteProject(string $projectId): Project
    {
        $response = $this->makeRequest('DELETE', "projects/{$projectId}");

        return Project::fromArray($response['project']);
    }

    public function connectionUri(
        string $projectId,
        ?string $databaseName = null,
        ?string $roleName = null,
        bool $pooled = false
    ): array {
        $params = $this->compactArray([
            'database_name' => $databaseName,
            'role_name'     => $roleName,
            'pooled'        => $pooled,
        ]);

        return $this->makeRequest('GET', "projects/{$projectId}/connection_uri", ['query' => $params]);
    }

    public function branches(string $projectId, ?string $cursor = null, ?int $limit = null): array
    {
        $params = $this->compactArray(['cursor' => $cursor, 'limit' => $limit]);

        return $this->makeRequest('GET', "projects/{$projectId}/branches", ['query' => $params]);
    }

    public function branch(string $projectId, string $branchId): Branch
    {
        $data = $this->makeRequest('GET', "projects/{$projectId}/branches/{$branchId}");

        return Branch::fromArray($data['branch']);
    }

    public function createBranch(string $projectId, array $data): array
    {
        return $this->makeRequest('POST', "projects/{$projectId}/branches", ['json' => $data]);
    }

    public function updateBranch(string $projectId, string $branchId, array $data): array
    {
        return $this->makeRequest('PATCH', "projects/{$projectId}/branches/{$branchId}", ['json' => $data]);
    }

    public function deleteBranch(string $projectId, string $branchId): array
    {
        return $this->makeRequest('DELETE', "projects/{$projectId}/branches/{$branchId}");
    }

    public function setBranchAsPrimary(string $projectId, string $branchId): array
    {
        return $this->makeRequest('POST', "projects/{$projectId}/branches/{$branchId}/set_as_primary");
    }

    public function endpoints(string $projectId): array
    {
        return $this->makeRequest('GET', "projects/{$projectId}/endpoints");
    }

    public function endpoint(string $projectId, string $endpointId): Endpoint
    {
        $data = $this->makeRequest('GET', "projects/{$projectId}/endpoints/{$endpointId}");

        return Endpoint::fromArray($data['endpoint']);
    }

    public function createEndpoint(string $projectId, array $data): array
    {
        return $this->makeRequest('POST', "projects/{$projectId}/endpoints", ['json' => $data]);
    }

    public function updateEndpoint(string $projectId, string $endpointId, array $data): array
    {
        return $this->makeRequest('PATCH', "projects/{$projectId}/endpoints/{$endpointId}", ['json' => $data]);
    }

    public function deleteEndpoint(string $projectId, string $endpointId): array
    {
        return $this->makeRequest('DELETE', "projects/{$projectId}/endpoints/{$endpointId}");
    }

    public function startEndpoint(string $projectId, string $endpointId): array
    {
        return $this->makeRequest('POST', "projects/{$projectId}/endpoints/{$endpointId}/start");
    }

    public function suspendEndpoint(string $projectId, string $endpointId): array
    {
        return $this->makeRequest('POST', "projects/{$projectId}/endpoints/{$endpointId}/suspend");
    }

    public function databases(
        string $projectId,
        string $branchId,
        ?string $cursor = null,
        ?int $limit = null
    ): array {
        $params = $this->compactArray(['cursor' => $cursor, 'limit' => $limit]);

        return $this->makeRequest('GET', "projects/{$projectId}/branches/{$branchId}/databases", ['query' => $params]);
    }

    public function database(string $projectId, string $branchId, string $databaseId): Database
    {
        $data = $this->makeRequest('GET', "projects/{$projectId}/branches/{$branchId}/databases/{$databaseId}");

        return Database::fromArray($data['database']);
    }

    public function createDatabase(string $projectId, string $branchId, array $data): Database
    {
        $response = $this->makeRequest('POST', "projects/{$projectId}/branches/{$branchId}/databases", ['json' => $data]);

        return Database::fromArray($response['database']);
    }

    public function updateDatabase(string $projectId, string $branchId, string $databaseId, array $data): Database
    {
        $response = $this->makeRequest('PATCH', "projects/{$projectId}/branches/{$branchId}/databases/{$databaseId}", ['json' => $data]);

        return Database::fromArray($response['database']);
    }

    public function deleteDatabase(string $projectId, string $branchId, string $databaseId): Database
    {
        $response = $this->makeRequest('DELETE', "projects/{$projectId}/branches/{$branchId}/databases/{$databaseId}");

        return Database::fromArray($response['database']);
    }

    public function roles(string $projectId, string $branchId): array
    {
        return $this->makeRequest('GET', "projects/{$projectId}/branches/{$branchId}/roles");
    }

    public function role(string $projectId, string $branchId, string $roleName): Role
    {
        $data = $this->makeRequest('GET', "projects/{$projectId}/branches/{$branchId}/roles/{$roleName}");

        return Role::fromArray($data['role']);
    }

    public function createRole(string $projectId, string $branchId, string $roleName): array
    {
        $data = ['role' => ['name' => $roleName]];

        return $this->makeRequest('POST', "projects/{$projectId}/branches/{$branchId}/roles", ['json' => $data]);
    }

    public function deleteRole(string $projectId, string $branchId, string $roleName): array
    {
        return $this->makeRequest('DELETE', "projects/{$projectId}/branches/{$branchId}/roles/{$roleName}");
    }

    public function revealRolePassword(string $projectId, string $branchId, string $roleName): array
    {
        return $this->makeRequest('POST', "projects/{$projectId}/branches/{$branchId}/roles/{$roleName}/reveal_password");
    }

    public function resetRolePassword(string $projectId, string $branchId, string $roleName): array
    {
        return $this->makeRequest('POST', "projects/{$projectId}/branches/{$branchId}/roles/{$roleName}/reset_password");
    }

    public function operations(string $projectId, ?string $cursor = null, ?int $limit = null): array
    {
        $params = $this->compactArray(['cursor' => $cursor, 'limit' => $limit]);

        return $this->makeRequest('GET', "projects/{$projectId}/operations", ['query' => $params]);
    }

    public function operation(string $projectId, string $operationId): Operation
    {
        $data = $this->makeRequest('GET', "projects/{$projectId}/operations/{$operationId}");

        return Operation::fromArray($data['operation']);
    }
}
