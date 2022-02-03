<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Recette;

class FileUploader
{
    private $imgDir;
    private $slugger;

    public function __construct($imgDir, SluggerInterface $slugger)
    {
        $this->imgDir = $imgDir;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file, array $extension)
    {
        if (in_array($file->guessExtension(), $extension)) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

            try {
                $file->move($this->getImgDirectory(), $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            return $fileName;
        }
    }

    public function getImgDirectory()
    {
        return $this->imgDir;
    }
}
