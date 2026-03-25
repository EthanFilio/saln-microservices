<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'service' => 'document-service',
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
    ]);
});

Route::post('/generate', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'form_data' => 'required|array',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Document generation is queued.',
        'data' => [
            'format' => 'pdf',
            'generated_at' => now()->toIso8601String(),
            'field_count' => count($validated['form_data']),
        ],
    ]);
});
