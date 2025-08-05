<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

enum OperationStatus: string
{
    case SCHEDULING = 'scheduling';
    case RUNNING    = 'running';
    case FINISHED   = 'finished';
    case FAILED     = 'failed';
    case ERROR      = 'error';
    case CANCELLED  = 'cancelled';
    case CANCELLING = 'cancelling';
    case SKIPPED    = 'skipped';
}
