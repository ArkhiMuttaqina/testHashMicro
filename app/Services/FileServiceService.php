<?php

namespace App\Services;

use App\Repositories\Contracts\FileServiceRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\File;

class FileServiceService
{
    protected $fileservicerepository;

    public function __construct(FileServiceRepositoryInterface $fileservicerepository)
    {
        $this->fileservicerepository = $fileservicerepository;
    }



}
