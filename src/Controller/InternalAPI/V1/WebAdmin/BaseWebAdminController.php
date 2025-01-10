<?php

namespace App\Controller\InternalAPI\V1\WebAdmin;

use App\Controller\InternalAPI\BaseInternalAPIController;
use App\Service\InternalAPI\WebAdmin\WebAdminErrorCodes;

class BaseWebAdminController extends BaseInternalAPIController
{
    use WebAdminErrorCodes;
}