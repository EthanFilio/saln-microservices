<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $userId = $request->input('user_id');
        
        $query = Form::with('user');
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        $forms = $query->latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $forms
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|uuid|exists:users,id',
            'form_data' => 'required|array',
            'status' => 'sometimes|in:draft,submitted,completed',
            'notes' => 'nullable|string',
        ]);

        $form = Form::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Form created successfully',
            'data' => $form
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $form = Form::with('user')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $form
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $form = Form::findOrFail($id);

        $validated = $request->validate([
            'form_data' => 'sometimes|array',
            'status' => 'sometimes|in:draft,submitted,completed',
            'notes' => 'nullable|string',
        ]);

        // Track changes if form_data is updated
        if (isset($validated['form_data'])) {
            $form->recordChange($validated['form_data'], $request->input('change_description', 'Form updated'));
        }

        $form->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Form updated successfully',
            'data' => $form->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $form = Form::findOrFail($id);
        $form->delete();

        return response()->json([
            'success' => true,
            'message' => 'Form deleted successfully'
        ]);
    }
}
