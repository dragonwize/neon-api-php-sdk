<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

enum EndpointState: string
{
    case INIT   = 'init';
    case ACTIVE = 'active';
    case IDLE   = 'idle';
}
