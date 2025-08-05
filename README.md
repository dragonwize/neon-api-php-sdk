# Neon API PHP Client

A PHP client library for the [Neon API](https://api-docs.neon.tech/reference/getting-started-with-neon-api).

`neon-api-php-sdk` is a PHP wrapper designed to simplify interactions with the [Neon API](https://api-docs.neon.tech/reference/getting-started-with-neon-api). 
It provides a convenient way for developers to integrate their PHP applications 
with the Neon platform, offering methods to manage API keys, projects, branches, 
databases, endpoints, roles, and operations programmatically.

## Requirements

- PHP 8.4 or higher
- Composer
- PSR 

## Installation

You can install the package via Composer:

```bash
composer require dragonwize/neon-api-sdk
```

## Usage

```php
<?php

use Dragonwize\NeonApiSdk\Client\NeonApi;

// Initialize the client with your API key
$neon = new NeonApi('your_api_key');

```

**Important**: Never expose your API key in your code. Always use environment 
variables or secure configuration management.

## API Methods

### User Information

- `me()`: Returns the current user information.

### API Key Management

- `apiKeys()`: Returns a list of API keys.
- `createApiKey(array $data)`: Creates a new API key.
- `revokeApiKey(string $apiKeyId)`: Revokes an API key.

### Project Management

- `projects(bool $shared = false, ?string $cursor = null, ?int $limit = null)`: Returns a list of projects.
- `project(string $projectId)`: Returns a specific project.
- `createProject(array $data)`: Creates a new project.
- `updateProject(string $projectId, array $data)`: Updates a project.
- `deleteProject(string $projectId)`: Deletes a project.
- `connectionUri(string $projectId, ?string $databaseName = null, ?string $roleName = null, bool $pooled = false)`: Returns the connection URI for a project.

### Branch Management

- `branches(string $projectId, ?string $cursor = null, ?int $limit = null)`: Returns a list of branches for a project.
- `branch(string $projectId, string $branchId)`: Returns a specific branch.
- `createBranch(string $projectId, array $data)`: Creates a new branch.
- `updateBranch(string $projectId, string $branchId, array $data)`: Updates a branch.
- `deleteBranch(string $projectId, string $branchId)`: Deletes a branch.
- `setBranchAsPrimary(string $projectId, string $branchId)`: Sets a branch as primary.

### Database Management

- `databases(string $projectId, string $branchId, ?string $cursor = null, ?int $limit = null)`: Returns a list of databases.
- `database(string $projectId, string $branchId, string $databaseId)`: Returns a specific database.
- `createDatabase(string $projectId, string $branchId, array $data)`: Creates a new database.
- `updateDatabase(string $projectId, string $branchId, string $databaseId, array $data)`: Updates a database.
- `deleteDatabase(string $projectId, string $branchId, string $databaseId)`: Deletes a database.

### Endpoint Management

- `endpoints(string $projectId)`: Returns a list of endpoints.
- `endpoint(string $projectId, string $endpointId)`: Returns a specific endpoint.
- `createEndpoint(string $projectId, array $data)`: Creates a new endpoint.
- `updateEndpoint(string $projectId, string $endpointId, array $data)`: Updates an endpoint.
- `deleteEndpoint(string $projectId, string $endpointId)`: Deletes an endpoint.
- `startEndpoint(string $projectId, string $endpointId)`: Starts an endpoint.
- `suspendEndpoint(string $projectId, string $endpointId)`: Suspends an endpoint.

### Role Management

- `roles(string $projectId, string $branchId)`: Returns a list of roles.
- `role(string $projectId, string $branchId, string $roleName)`: Returns a specific role.
- `createRole(string $projectId, string $branchId, string $roleName)`: Creates a new role.
- `deleteRole(string $projectId, string $branchId, string $roleName)`: Deletes a role.
- `revealRolePassword(string $projectId, string $branchId, string $roleName)`: Reveals a role password.
- `resetRolePassword(string $projectId, string $branchId, string $roleName)`: Resets a role password.

### Operation Management

- `operations(string $projectId, ?string $cursor = null, ?int $limit = null)`: Returns a list of operations.
- `operation(string $projectId, string $operationId)`: Returns a specific operation.

## Examples

### Create a Project

```php
<?php

use Dragonwize\NeonApiSdk\Client\NeonApi;

$neon = NeonApi::fromEnvironment();

$project = $neon->createProject([
    'project' => [
        'name' => 'My New Project',
        'region_id' => 'aws-us-east-1',
    ]
]);

echo "Created project: " . $project->name . " with ID: " . $project->id;
```

### Create a Branch

```php
<?php

use Dragonwize\NeonApiSdk\Client\NeonApi;

$neon = NeonApi::fromEnvironment();

$response = $neon->createBranch('project-id', [
    'branch' => [
        'name' => 'feature-branch',
    ]
]);
```

### Get Connection URI

```php
<?php

use Dragonwize\NeonApiSdk\Client\NeonApi;

$neon = NeonApi::fromEnvironment();

$connectionData = $neon->connectionUri(
    'project-id', 
    'database-name', 
    'role-name'
);

echo "Connection URI: " . $connectionData['uri'];
```

## Error Handling

The client throws `NeonApiException` for API errors:

```php
<?php

use Dragonwize\NeonApiSdk\Client\NeonApi;
use Dragonwize\NeonApiSdk\Exception\NeonApiException;

try {
    $neon = NeonApi::fromEnvironment();
    $project = $neon->project('invalid-project-id');
} catch (NeonApiException $e) {
    echo "API Error: " . $e->getMessage();
}
```

## Data Models

The library includes strongly-typed data models for API responses:

- `Project`: Represents a Neon project
- `Branch`: Represents a project branch
- `Database`: Represents a database
- `Endpoint`: Represents a compute endpoint
- `Role`: Represents a database role
- `Operation`: Represents an operation

These models provide type safety and IDE autocompletion.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Links

- [Neon API Documentation](https://api-docs.neon.tech/reference/getting-started-with-neon-api)
- [Neon Console](https://console.neon.tech/)
