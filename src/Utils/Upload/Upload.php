<?php
namespace Utils\Upload;

use \Exception;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as Adapter;
use App\Models\Upload as UploadModel;

class Upload
{
    private $baseDirectory;
    private $fileSystem;

    public function __construct($baseDirectory) {
        if (!is_dir($baseDirectory)) {
            throw new Exception("This path is not directory", 1);
        }

        $this->baseDirectory = $baseDirectory;
        $this->fileSystem = new Filesystem(new Adapter($this->baseDirectory));
    }

    public function getBaseDirectory() {
        return $this->baseDirectory;
    }

    public function send($path, $filename, $folder)
    {
        if (!is_file($path)){
            throw new Exception("This file is not exist", 2);
        }

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $stream = fopen($path, 'r+');

        $this->fileSystem->writeStream(
            $folder . $filename . '.' . $ext, 
            $stream
        );

        fclose($stream);
        
        return $this->has($folder . $filename . '.' . $ext);
    }

    public function has($path) {
        return $this->fileSystem->has($path);
    }
}