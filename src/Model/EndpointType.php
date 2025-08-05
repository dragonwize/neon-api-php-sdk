<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

enum EndpointType: string
{
    case READ_ONLY  = 'read_only';
    case READ_WRITE = 'read_write';
}
