<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Exception\NeonApiException;
use Dragonwize\NeonApiSdk\Model\Branch;
use Dragonwize\NeonApiSdk\Model\Database;
use Dragonwize\NeonApiSdk\Model\Endpoint;
use Dragonwize\NeonApiSdk\Model\Operation;
use Dragonwize\NeonApiSdk\Model\NeonProject;
use Dragonwize\NeonApiSdk\Model\Role;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class NeonApi
{
    protected const string BASE_URL = 'https://console.neon.tech/api/v2/';

    public function __construct(
        protected string $apiKey,
        protected ClientInterface $httpClient,
        protected RequestFactoryInterface $httpMessageFactory,
        protected string $baseUrl = self::BASE_URL,
    ) {}

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    public function createRequest(string $method, string $uri): RequestInterface
    {
        $request = $this->httpMessageFactory->createRequest($method, $this->baseUrl . $uri);
        $request->withHeader('Content-Type', 'application/json')
                ->withHeader('Accept', 'application/json')
                ->withHeader('Authorization', 'Bearer ' . $this->apiKey)
                ->withHeader('User-Agent', 'DragonwizeNeonApiPhpSdk/1');

        return $request;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->getHttpClient()->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new NeonApiException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function parseResponse(ResponseInterface $response): array
    {
        $data = json_decode((string)$response->getBody(), true);

        if (json_last_error() !== \JSON_ERROR_NONE) {
            throw new NeonApiException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $data ?? [];
    }

    public function buildQuery(array $params): string
    {
        $query = http_build_query($params);

        return ($query ? '?' . $query : '');
    }

    public function me(): array
    {
        return $this->sendRequest('GET', 'users/me');
    }

    public function apiKeys(): array
    {
        return $this->sendRequest('GET', 'api_keys');
    }

    public function createApiKey(array $data): array
    {
        return $this->sendRequest('POST', 'api_keys', ['json' => $data]);
    }

    public function revokeApiKey(string $apiKeyId): array
    {
        return $this->sendRequest('DELETE', "api_keys/{$apiKeyId}");
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

        return $this->sendRequest('GET', "projects/{$projectId}/connection_uri", ['query' => $params]);
    }

    public function branches(string $projectId, ?string $cursor = null, ?int $limit = null): array
    {
        $params = $this->compactArray(['cursor' => $cursor, 'limit' => $limit]);

        return $this->sendRequest('GET', "projects/{$projectId}/branches", ['query' => $params]);
    }

    public function branch(string $projectId, string $branchId): Branch
    {
        $data = $this->sendRequest('GET', "projects/{$projectId}/branches/{$branchId}");

        return Branch::fromArray($data['branch']);
    }

    public function createBranch(string $projectId, array $data): array
    {
        return $this->sendRequest('POST', "projects/{$projectId}/branches", ['json' => $data]);
    }

    public function updateBranch(string $projectId, string $branchId, array $data): array
    {
        return $this->sendRequest('PATCH', "projects/{$projectId}/branches/{$branchId}", ['json' => $data]);
    }

    public function deleteBranch(string $projectId, string $branchId): array
    {
        return $this->sendRequest('DELETE', "projects/{$projectId}/branches/{$branchId}");
    }

    public function setBranchAsPrimary(string $projectId, string $branchId): array
    {
        return $this->sendRequest('POST', "projects/{$projectId}/branches/{$branchId}/set_as_primary");
    }

    public function endpoints(string $projectId): array
    {
        return $this->sendRequest('GET', "projects/{$projectId}/endpoints");
    }

    public function endpoint(string $projectId, string $endpointId): Endpoint
    {
        $data = $this->sendRequest('GET', "projects/{$projectId}/endpoints/{$endpointId}");

        return Endpoint::fromArray($data['endpoint']);
    }

    public function createEndpoint(string $projectId, array $data): array
    {
        return $this->sendRequest('POST', "projects/{$projectId}/endpoints", ['json' => $data]);
    }

    public function updateEndpoint(string $projectId, string $endpointId, array $data): array
    {
        return $this->sendRequest('PATCH', "projects/{$projectId}/endpoints/{$endpointId}", ['json' => $data]);
    }

    public function deleteEndpoint(string $projectId, string $endpointId): array
    {
        return $this->sendRequest('DELETE', "projects/{$projectId}/endpoints/{$endpointId}");
    }

    public function startEndpoint(string $projectId, string $endpointId): array
    {
        return $this->sendRequest('POST', "projects/{$projectId}/endpoints/{$endpointId}/start");
    }

    public function suspendEndpoint(string $projectId, string $endpointId): array
    {
        return $this->sendRequest('POST', "projects/{$projectId}/endpoints/{$endpointId}/suspend");
    }

    public function databases(
        string $projectId,
        string $branchId,
        ?string $cursor = null,
        ?int $limit = null
    ): array {
        $params = $this->compactArray(['cursor' => $cursor, 'limit' => $limit]);

        return $this->sendRequest('GET', "projects/{$projectId}/branches/{$branchId}/databases", ['query' => $params]);
    }

    public function database(string $projectId, string $branchId, string $databaseId): Database
    {
        $data = $this->sendRequest('GET', "projects/{$projectId}/branches/{$branchId}/databases/{$databaseId}");

        return Database::fromArray($data['database']);
    }

    public function createDatabase(string $projectId, string $branchId, array $data): Database
    {
        $response = $this->sendRequest('POST', "projects/{$projectId}/branches/{$branchId}/databases", ['json' => $data]);

        return Database::fromArray($response['database']);
    }

    public function updateDatabase(string $projectId, string $branchId, string $databaseId, array $data): Database
    {
        $response = $this->sendRequest('PATCH', "projects/{$projectId}/branches/{$branchId}/databases/{$databaseId}", ['json' => $data]);

        return Database::fromArray($response['database']);
    }

    public function deleteDatabase(string $projectId, string $branchId, string $databaseId): Database
    {
        $response = $this->sendRequest('DELETE', "projects/{$projectId}/branches/{$branchId}/databases/{$databaseId}");

        return Database::fromArray($response['database']);
    }

    public function roles(string $projectId, string $branchId): array
    {
        return $this->sendRequest('GET', "projects/{$projectId}/branches/{$branchId}/roles");
    }

    public function role(string $projectId, string $branchId, string $roleName): Role
    {
        $data = $this->sendRequest('GET', "projects/{$projectId}/branches/{$branchId}/roles/{$roleName}");

        return Role::fromArray($data['role']);
    }

    public function createRole(string $projectId, string $branchId, string $roleName): array
    {
        $data = ['role' => ['name' => $roleName]];

        return $this->sendRequest('POST', "projects/{$projectId}/branches/{$branchId}/roles", ['json' => $data]);
    }

    public function deleteRole(string $projectId, string $branchId, string $roleName): array
    {
        return $this->sendRequest('DELETE', "projects/{$projectId}/branches/{$branchId}/roles/{$roleName}");
    }

    public function revealRolePassword(string $projectId, string $branchId, string $roleName): array
    {
        return $this->sendRequest('POST', "projects/{$projectId}/branches/{$branchId}/roles/{$roleName}/reveal_password");
    }

    public function resetRolePassword(string $projectId, string $branchId, string $roleName): array
    {
        return $this->sendRequest('POST', "projects/{$projectId}/branches/{$branchId}/roles/{$roleName}/reset_password");
    }

    public function operations(string $projectId, ?string $cursor = null, ?int $limit = null): array
    {
        $params = $this->compactArray(['cursor' => $cursor, 'limit' => $limit]);

        return $this->sendRequest('GET', "projects/{$projectId}/operations", ['query' => $params]);
    }

    public function operation(string $projectId, string $operationId): Operation
    {
        $data = $this->sendRequest('GET', "projects/{$projectId}/operations/{$operationId}");

        return Operation::fromArray($data['operation']);
    }
}
