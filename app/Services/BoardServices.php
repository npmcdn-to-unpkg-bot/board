<?php

namespace App\Services;

use App\Services\AppEnum;
use App\Services\StorageService;

class BoardServices
{
    /**
     * @param $disk
     * @param $file
     * @return mixed
     */
    public function loadFile($disk, $file)
    {
        $storage = new StorageService();
        $image = $storage->setStorage($disk)
            ->addFile($file)
            ->save();
        if($image) {
            return $storage->getName();
        } else {
            return $storage->getErrors();
        }
    }
}