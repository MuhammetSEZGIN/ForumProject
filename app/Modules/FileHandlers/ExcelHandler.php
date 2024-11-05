<?php

namespace App\Modules\FileHandlers;

class ExcelHandler implements FileHandlerInterface
{
    public function export(array $data): string
    {
        // Export data to excel
        return "";
    }
    public function import($filePath): array
    {
        // Import data from excel
        return [];
    }


}
