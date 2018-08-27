<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload($path, UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDirectory().$path, $fileName);

        return $fileName;
    }

    public function delete($path, $filename)
    {
        if (file_exists($this->getTargetDirectory() . $path.$filename))
            unlink($this->getTargetDirectory() . $path.$filename);

    }
    
    protected function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
