<?php

namespace App\Modules\FileHandlers;

use PhpOffice\PhpWord\IOFactory;

class WordHandler implements FileHandlerInterface
{
    public function export(array $data, string $fileName): string
    {
        // Export data to word

        return $fileName.'.docx';
    }
    public function import($filePath): array{
        $phpWord = IOFactory::load($filePath);
        $data = [];

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $data[] = $element->getText();
                }
            }
        }

        return $data;
    }
}
