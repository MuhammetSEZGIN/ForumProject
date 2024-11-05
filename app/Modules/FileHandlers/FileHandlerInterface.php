<?php

namespace App\Modules\FileHandlers;

interface FileHandlerInterface
{
    // Export edilen dosyanın path'ini döndürür
    public function export(array $data): string;
    // Import edilen dosyanın içeriğini döndürür
    public function import($filePath): array;
}
