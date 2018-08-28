<?php

namespace Sacprd\Core;

use AppBundle\Service\FileUploader;

trait FileUploaderTrait
{
    public function saveFiles($files, FileUploader $uploader)
    {
        $file = $files->get('preview');
        if ($file) {
            $fileName = $uploader->upload(self::LOCAL_PATH, $file);
            $this->setPreview($fileName);
        }
        
        if (($this->oldpreview != $this->preview) && $this->oldpreview) {
            $uploader->delete(self::LOCAL_PATH, $this->oldpreview);
        } 
        
        return $this;
    }
    
    public function deleteFiles(FileUploader $uploader)
    {
        if ($this->oldpreview) {
            $uploader->delete(self::LOCAL_PATH, $this->oldpreview);
        } 
        
        return $this;        
    }
}