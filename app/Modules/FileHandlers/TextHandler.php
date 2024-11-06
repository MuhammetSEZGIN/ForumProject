<?php

namespace App\Modules\FileHandlers;

class TextHandler implements FileHandlerInterface
{
    public function export(array $data, string $fileName): string
    {
        // Export data to text
        return "";
    }
    public function import($filePath): array{
        // Import data from text
        return [];
    }

}

