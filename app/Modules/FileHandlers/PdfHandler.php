<?php

namespace App\Modules\FileHandlers;

class PdfHandler implements FileHandlerInterface
{
    public function export(array $data, string $fileName): string
    {
        // Export data to pdf
        return "";
    }
    public function import($filePath): array{
        // Import data from pdf
        return [];
    }

}
