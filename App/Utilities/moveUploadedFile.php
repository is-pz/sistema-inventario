<?php

namespace App\Utilities;

use Psr\Http\Message\UploadedFileInterface;

class moveUploadedFile
{
    public function moveFile($directory, UploadedFileInterface $uploadedFile){
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $nameFile = pathinfo($uploadedFile->getClientFilename(), PATHINFO_FILENAME);


        $filename = sprintf('%s.%0.8s', $nameFile, $extension);
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
    
        return $filename;
    }
}
