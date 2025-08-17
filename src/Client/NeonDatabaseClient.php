<?php declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Exception\NeonApiRequestException;
use Dragonwize\NeonApiSdk\Exception\NeonApiResponseException;
use Dragonwize\NeonApiSdk\Model\NeonDatabase;
use Dragonwize\NeonApiSdk\Model\NeonOperation;
use Dragonwize\NeonApiSdk\NeonApiInterface;

/**
 * Manage Neon databases.
 */
class NeonDatabaseClient
{
    public function __construct(protected NeonApiInterface $api)
    {}

    /**
     * Retrieves a list of databases for the specified branch.
     *
     * A branch can have multiple databases.
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain the branch_id by listing the project's branches.
     *
     * @see https://api-docs.neon.tech/reference/listprojectbranchdatabases
     *
     * @return array<NeonDatabase>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function list(string $projectId, string $branchId): array
    {
        $response = $this->api->get("projects/{$projectId}/branches/{$branchId}/databases");
        $databases = [];
        foreach ($response['databases'] as $database) {
            $databases[] = NeonDatabase::create($database);
        }

        return $databases;
    }

    /**
     * Retrieves information about the specified database.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain the branch_id and database_name by listing the branch's databases.
     *
     * @see https://api-docs.neon.tech/reference/getprojectbranchdatabase
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function get(string $projectId, string $branchId, string $databaseName): NeonDatabase
    {
        $response = $this->api->get("projects/{$projectId}/branches/{$branchId}/databases/{$databaseName}");
        
        return NeonDatabase::create($response['database']);
    }

    /**
     * Creates a database in the specified branch.
     *
     * A branch can have multiple databases.
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain the branch_id by listing the project's branches.
     *
     * @see https://api-docs.neon.tech/reference/createprojectbranchdatabase
     *
     * @param array $data Database creation data (name, owner_name)
     *
     * @return array{database: NeonDatabase, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function create(string $projectId, string $branchId, array $data): array
    {
        $response = $this->api->post("projects/{$projectId}/branches/{$branchId}/databases", ['database' => $data]);
        
        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }
        
        return [
            'database' => NeonDatabase::create($response['database']),
            'operations' => $operations
        ];
    }

    /**
     * Updates the specified database in the branch.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain the branch_id and database_name by listing the branch's databases.
     *
     * @see https://api-docs.neon.tech/reference/updateprojectbranchdatabase
     *
     * @param array $data Database update data (name, owner_name)
     *
     * @return array{database: NeonDatabase, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function update(string $projectId, string $branchId, string $databaseName, array $data): array
    {
        $response = $this->api->sendRequest('PATCH', "projects/{$projectId}/branches/{$branchId}/databases/{$databaseName}", ['json' => ['database' => $data]]);
        
        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }
        
        return [
            'database' => NeonDatabase::create($response['database']),
            'operations' => $operations
        ];
    }

    /**
     * Deletes the specified database from the branch.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain the branch_id and database_name by listing the branch's databases.
     *
     * @see https://api-docs.neon.tech/reference/deleteprojectbranchdatabase
     *
     * @return array{database: NeonDatabase, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function delete(string $projectId, string $branchId, string $databaseName): array
    {
        $response = $this->api->sendRequest('DELETE', "projects/{$projectId}/branches/{$branchId}/databases/{$databaseName}");
        
        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }
        
        return [
            'database' => NeonDatabase::create($response['database']),
            'operations' => $operations
        ];
    }
}