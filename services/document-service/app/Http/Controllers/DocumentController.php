<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Jobs\GeneratePdfJob;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'form_data' => 'required|array',  // values to fill
        ]);

        $template = '1-A Rules Annex A_2025 SALN Form Updated Form as of 3 February 2026';

        // creates (will edit this pa prob, cus right now its just creating default annex a)
        $doc = Document::create([
            'template' => $template,
            'form_data' => $validated['form_data'],
            'status' => 'queued',
        ]);

        GeneratePdfJob::dispatch($doc->id);
    
        return response()->json([
            'success' => true,
            'document_id' => $doc->id,
            'status' => $doc->status,
        ], 202);
    }

    public function show(int $id)
    {
        $doc = Document::findOrFail($id);

        return response()->json([
            'id' => $doc->id,
            'template' => $doc->template,
            'status' => $doc->status,
            'output_path' => $doc->output_path,
            'error_message' => $doc->error_message,
            'created_at' => $doc->created_at,
            'updated_at' => $doc->updated_at,
        ]);
    }

    public function download(int $id)
    {
        $doc = Document::findOrFail($id);

        if ($doc->status !== 'completed' || !$doc->output_path) {
            return response()->json([
                'success' => false,
                'message' => 'Document not ready for download.',
                'status' => $doc->status,
            ], 409);
        }

        if (!Storage::disk('local')->exists($doc->output_path)) {
            return response()->json([
                'success' => false,
                'message' => 'Generated file is missing from storage.',
            ], 404);
        }

        return Storage::disk('local')->download(
            $doc->output_path,
            "{$doc->template}-{$doc->id}.pdf"
        );
    }

}