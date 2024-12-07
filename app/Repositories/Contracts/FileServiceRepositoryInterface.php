<?php

namespace App\Repositories\Contracts;

interface FileServiceRepositoryInterface
{
    public function getFilePath(string $fileName): string;
    public function validateFileExists(string $filePath): void;
    public function uploadFile($file, string $uploadPath): string;
    public function deleteFile(string $filePath): bool;
}
