<?php

namespace App\Jobs;

use App\Models\Document;
use App\Services\PdfFormFiller;
use App\Services\PdfFormMapper;
use App\Services\PdfFormMerger;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $documentId)
    {
    }

    public function handle(
        PdfFormFiller $filler,
        PdfFormMapper $mapper,
        PdfFormMerger $merger
    ): void {
        $doc = Document::findOrFail($this->documentId);

        $doc->update([
            'status' => 'processing',
            'error_message' => null,
        ]);

        try {
            // 1) Map your stored form_data into the field/value structure needed by the template
            $mappedData = $mapper->map($doc->form_data);

            // 2) Fill template -> raw PDF bytes
            $filledBasePath = $filler->fillToFile($doc->template, $mappedData);

            // 3) Merge (implementation pending)
            // TODO: $mergedPath = $merger->mergeToFile([$filledBasePath, ...$annexPaths]);
            $mergedPath = $filledBasePath;

            // 4) Store merged bytes
            $fileName = "generated/{$doc->id}-{$doc->template}.pdf";
            Storage::disk('local')->put($fileName, file_get_contents($mergedPath));


            $doc->update([
                'status' => 'completed',
                'output_path' => $fileName,
            ]);
        } catch (Exception $e) {
            $doc->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}