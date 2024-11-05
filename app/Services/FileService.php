<?php

namespace App\Services;

use App\Modules\FileHandlers\FileHandlerInterface;

/*
 * Yeni dosya formatları eklemek istediğimizde FileHandler kısmına eklememiz yeterli olacaktır
 * Bu yapıyı değiştirmemize gerek kalmayacaktır
 * Unit testlerde kolaylık sağlayacaktır
 * */
class FileService
{
    protected FileHandlerInterface $fileHandler;
    public function __construct(FileHandlerInterface $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    public function export(array $data): string
    {
        return $this->fileHandler->export($data);
    }
    public function import($filePath): array
    {
        return $this->fileHandler->import($filePath);
    }

}
