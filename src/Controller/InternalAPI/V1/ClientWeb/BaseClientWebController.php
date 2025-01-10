<?php

namespace App\Controller\InternalAPI\V1\ClientWeb;

use App\Controller\InternalAPI\BaseInternalAPIController;
use App\Service\InternalAPI\ClientWeb\ClientWebErrorCodes;

class BaseClientWebController extends BaseInternalAPIController
{
    use ClientWebErrorCodes;
}