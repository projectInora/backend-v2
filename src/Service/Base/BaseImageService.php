<?php

namespace App\Service\Base;

use App\Entity\Image\Images;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class BaseImageService extends BaseService implements IBaseImageService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    /**
     * @param UploadedFile $image
     * @param string $destination
     * @param string|null $fileName
     * @param array|null $asp
     * @param bool $isFlush
     * @return array|Images
     */
    function uploadImageLocally(UploadedFile $image, string $destination, string $fileName = null, array $asp = null, bool $isFlush = false): array|Images
    {
        try{
            if ($image->isValid()) {
                $rec = new Images();
                $safeFilename = $fileName ?? $rec->getUuid();
                $newFilename = $safeFilename.'.'.$image->guessExtension();
                $ext = $image->guessExtension();
                $image->move(
                     $destination,
                    $newFilename
                );
                
                $rec->setName($safeFilename);
                $rec->setFullImageName($newFilename);
                $rec->setExtension($ext);
                $rec->setLocalPath($newFilename, $destination.$newFilename);
                if(!empty($asp) && count($asp) > 1){
                    $rec->setAspDivWidth(floatval($asp[0] ?? 0));
                    $rec->setAspDivHeight(floatval($asp[1] ?? 0));
                }
                $this->em->persist($rec);
                if ($isFlush) {
                    $this->em->flush();
                }
                return $rec;
            } else {
                return ['error'=>$this->getErrorMessage('BEI00001'), 'formErrors' => [], 'status' => false];
            }
        }
        catch (Exception $e){
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false];
        }
    }
}