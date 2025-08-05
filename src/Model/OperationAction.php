<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

enum OperationAction: string
{
    case CREATE_COMPUTE     = 'create_compute';
    case CREATE_TIMELINE    = 'create_timeline';
    case START_COMPUTE      = 'start_compute';
    case SUSPEND_COMPUTE    = 'suspend_compute';
    case APPLY_CONFIG       = 'apply_config';
    case CHECK_AVAILABILITY = 'check_availability';
    case DELETE_TIMELINE    = 'delete_timeline';
    case CREATE_BRANCH      = 'create_branch';
    case DELETE_BRANCH      = 'delete_branch';
    case UPDATE_BRANCH      = 'update_branch';
    case CREATE_DATABASE    = 'create_database';
    case UPDATE_DATABASE    = 'update_database';
    case DELETE_DATABASE    = 'delete_database';
    case CREATE_ROLE        = 'create_role';
    case DELETE_ROLE        = 'delete_role';
    case CREATE_ENDPOINT    = 'create_endpoint';
    case UPDATE_ENDPOINT    = 'update_endpoint';
    case DELETE_ENDPOINT    = 'delete_endpoint';
    case START_ENDPOINT     = 'start_endpoint';
    case SUSPEND_ENDPOINT   = 'suspend_endpoint';
    case CREATE_PROJECT     = 'create_project';
    case UPDATE_PROJECT     = 'update_project';
}
