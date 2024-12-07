<?php

namespace App\Repositories;

use App\Models\Departments;
use App\Models\JobTitles;
use App\Repositories\Contracts\FileServiceRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\File;

class FileServiceRepository implements FileServiceRepositoryInterface
{
    public function getFilePath(string $fileName): string
    {
        return public_path('files_upload/') . $fileName;
    }

    public function validateFileExists(string $filePath): void
    {
        if (!File::exists($filePath)) {
            throw new Exception('File not found');
        }
    }


    public function uploadFile($file, string $uploadPath): string
    {
        $originName = $file->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $fileName . '.' . $extension;

        $file->move($uploadPath, $fileName);

        return $fileName;
    }

    public function deleteFile(string $filePath): bool
    {
        if (File::exists($filePath)) {
            return File::delete($filePath);
        }

        return false; // Return false if the file does not exist.
    }
}
