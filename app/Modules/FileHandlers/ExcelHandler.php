<?php

namespace App\Modules\FileHandlers;
use Shuchkin\SimpleXLSXGen;
class ExcelHandler implements FileHandlerInterface
{
    public function export(array $data, string $fileName): string
    {
        $xlsx = SimpleXLSXGen::fromArray( $data, $fileName);
        $xlsx->downloadAs($fileName.'.xlsx');
        return $fileName.'.xlsx';
    }
    public function import($filePath): array
    {
        // Import data from excel
        return [];
    }


}
