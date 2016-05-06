<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;

class StorageService
{
    /** b64 code of the file
     * @var
     */
    protected $file;
    /**
     * @var
     */
    protected $errors;
    /**  Name of the storage
     * @var
     */
    protected $storage;
    /** Storage disk
     * @var
     */
    protected $disk;
    /** Name of the file
     * @var
     */
    protected $name;
    /** Type of the file
     * @var
     */
    protected $type;

    public static function create()
    {
        return new self();
    }

    /**
     * @param $storage
     * @return $this
     */
    public function setStorage($storage)
    {
        $this->disk = Storage::disk($storage);
        $this->storage = $storage;
        return $this;
    }

    /**
     * @param $file
     * @return $this
     */
    public function addFile($file)
    {
        $type = $this->getFileType($file);

        if ($type != false) {
            $this->type = $type;
            $this->file = base64_decode(str_replace('data:image/'.$type.';base64', '',$file));
        } else {
            $this->errors = AppEnum::ERROR_SAVE;
        }
        return $this;
    }

    /**
     * @param $file
     * @return bool
     */
    public function getFileType($file)
    {
        return (!preg_match('/data:([^;]*);base64,(.*)/', $file, $matches)) ? false : explode("/",$matches[1])[1];
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $path = explode("/",$name);
        $this->name = array_pop($path);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return '/images/'.$this->storage.'/'.$this->name;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return ($this->errors) ? $this->errors : $this->name;
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (strlen($this->name) == 0 || $this->disk->exists($this->name)) {
            if ($this->disk->exists($this->name)) {
                $this->disk->remove($this->name);
            }
            $this->name = $this->createName();
        }
        if (! $this->disk->put($this->name,$this->file)) {
            $this->errors = AppEnum::ERROR_SAVE;
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return string
     */
    public function createName()
    {
        return 'file_'.substr(md5(date('Y-m-d H:i:s:u')),0,6) . '.'. $this->type;
    }
}