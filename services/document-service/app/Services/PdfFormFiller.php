<?php

namespace App\Services;
require 'vendor/autoload.php';

use mikehaertl\pdftk\Pdf;
use RuntimeException;

class PdfFormFiller
{

   public function fillToFile(string $templateKey, array $mappedData): string
    {
        $pdfPath = resource_path("pdf/{$templateKey}.pdf");
        if (!file_exists($pdfPath)) {
            throw new \RuntimeException("Template PDF not found: {$pdfPath}");
        }

        // change?
        $outPath = storage_path("app/tmp/filled-{$templateKey}-" . ".pdf");
        @mkdir(dirname($outPath), 0775, true);

        $pdf = new Pdf($pdfPath);

        $ok = $pdf->fillForm($mappedData)
            ->needAppearances()
            ->flatten()
            ->saveAs($outPath);

        if ($ok === false) {
            throw new \RuntimeException("pdftk failed: " . $pdf->getError());
        }

        return $outPath;
    }
}