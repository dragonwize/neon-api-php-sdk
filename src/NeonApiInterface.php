<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk;

use Dragonwize\NeonApiSdk\Exception\NeonApiException;
use Dragonwize\NeonApiSdk\Model\NeonModelInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Neon API configuration and utility methods.
 */
interface NeonApiInterface
{
    public function getApiKey(): string;

    public function getBaseUrl(): string;

    public function getHttpClient(): ClientInterface;

    public function getRequestFactory(): RequestFactoryInterface;

    public function getStreamFactory(): StreamFactoryInterface;

    /**
     * Creates a new PSR-7 request with some default configuration.
     */
    public function createRequest(string $method, string $uri): RequestInterface;

    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @throws NeonApiException
     */
    public function sendRequest(RequestInterface $request): ResponseInterface;

    /**
     * Decodes a PSR-7 response body into a PHP array.
     *
     * @return array<mixed>|null
     *
     * @throws NeonApiException
     */
    public function parseResponse(ResponseInterface $response): ?array;

    /**
     * Create a HTTP query string from an array of parameters.
     *
     * @param array<string, mixed> $params
     */
    public function buildQuery(array $params): string;

    /**
     * Convenient method to make a GET request to the Neon API.
     *
     * @return array<mixed>
     */
    public function get(string $uri): array;

    /**
     * Convenient method to make a POST request to the Neon API.
     *
     * @param NeonModelInterface|array<mixed>|null $body
     *
     * @return array<mixed>
     */
    public function post(string $uri, NeonModelInterface|array|null $body = null): array;

    /**
     * Convenient method to make a PATCH request to the Neon API.
     *
     * @param NeonModelInterface|array<mixed>|null $body
     *
     * @return array<mixed>
     */
    public function patch(string $uri, NeonModelInterface|array|null $body = null): array;

    /**
     * Convenient method to make a PUT request to the Neon API.
     *
     * @param NeonModelInterface|array<mixed>|null $body
     *
     * @return array<mixed>
     */
    public function put(string $uri, NeonModelInterface|array|null $body = null): array;

    /**
     * Convenient method to make a DELETE request to the Neon API.
     *
     * @return array<mixed>
     */
    public function delete(string $uri): array;
}
