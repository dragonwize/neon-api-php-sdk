<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk;

use Dragonwize\NeonApiSdk\Exception\NeonApiException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Neon API configuration and utility methods.
 */
interface NeonApiInterface
{
    public function getApiKey(): string;

    public function getBaseUrl(): string;

    public function getHttpClient(): ClientInterface;

    public function getHttpMessageFactory(): RequestFactoryInterface;

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
     * @throws NeonApiException
     */
    public function parseResponse(ResponseInterface $response): array;

    /**
     * Create a HTTP query string from an array of parameters.
     *
     * @param array<string, string|int|bool> $params
     */
    public function buildQuery(array $params): string;
}
