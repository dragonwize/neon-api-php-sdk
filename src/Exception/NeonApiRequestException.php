<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Exception;

use Psr\Http\Message\RequestInterface;

class NeonApiRequestException extends NeonApiException
{
    public readonly RequestInterface $request;

    public function __construct(RequestInterface $request, ?\Throwable $previous = null)
    {
        $this->request = $request;

        parent::__construct('Neon API request failed: ' . $previous->getMessage(), $previous->getCode(), $previous);
    }
}
