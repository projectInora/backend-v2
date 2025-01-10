<?php

namespace App\Controller\InternalAPI\V1\ClientWeb\CMS\HomePage;

use App\Controller\InternalAPI\V1\ClientWeb\BaseClientWebController;
use App\Service\InternalAPI\CMS\Banner\IBannerGroupService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/internal-api/v1/client-web-open/cms/home-page')]
class CMSHomePageOpenController extends BaseClientWebController
{
    #[Route('/main-banners', name: 'ia_v1_uw_cms_home_main_banners', methods: ['GET'])]
    public function viewAllDestinations(Request $request, IBannerGroupService $bannerGroupService): JsonResponse
    {
        $mainBanners = $bannerGroupService->getHomePageMainBannerGroup();
        $response = new JsonResponse(['status'=>'true', 'result'=>['mainBannerGroup'=>$mainBanners]], Response::HTTP_OK);
        return $this->getJsonApiResponseHeaders($response);
    }
}