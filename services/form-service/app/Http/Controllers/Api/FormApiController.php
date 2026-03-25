<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormApiController extends Controller
{
    public function latest(Request $request): JsonResponse
    {
        $userId = $this->resolveUserId($request);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing or invalid user ID.',
            ], 422);
        }

        $form = Form::where('user_id', $userId)->latest()->first();

        return response()->json([
            'success' => true,
            'data' => $form,
        ]);
    }

    public function save(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'form_data' => 'required|array',
        ]);

        $userId = $this->resolveUserId($request);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing or invalid user ID.',
            ], 422);
        }

        $form = Form::where('user_id', $userId)->latest()->first();

        if ($form) {
            $form->update([
                'form_data' => $validated['form_data'],
                'status' => 'draft',
            ]);
        } else {
            $form = Form::create([
                'user_id' => $userId,
                'form_data' => $validated['form_data'],
                'status' => 'draft',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Form saved successfully.',
            'data' => $form,
        ]);
    }

    public function export(Request $request): JsonResponse
    {
        $userId = $this->resolveUserId($request);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing or invalid user ID.',
            ], 422);
        }

        $form = Form::where('user_id', $userId)->latest()->first();

        if (!$form) {
            return response()->json([
                'success' => false,
                'message' => 'No form data to export.',
            ], 404);
        }

        return response()->json($form->form_data ?? []);
    }

    public function import(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'form_data' => 'required|array',
        ]);

        $userId = $this->resolveUserId($request);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing or invalid user ID.',
            ], 422);
        }

        $form = Form::where('user_id', $userId)->latest()->first();

        if ($form) {
            $form->update([
                'form_data' => $validated['form_data'],
                'status' => 'draft',
            ]);
        } else {
            $form = Form::create([
                'user_id' => $userId,
                'form_data' => $validated['form_data'],
                'status' => 'draft',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Form imported successfully.',
            'data' => $form,
        ]);
    }

    public function newEntry(Request $request): JsonResponse
    {
        $userId = $this->resolveUserId($request);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing or invalid user ID.',
            ], 422);
        }

        $currentForm = Form::where('user_id', $userId)->latest()->first();

        if ($currentForm) {
            $currentForm->update(['status' => 'archived']);
        }

        return response()->json([
            'success' => true,
            'message' => 'New form entry started.',
        ]);
    }

    public function purge(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|uuid',
        ]);

        Form::where('user_id', $validated['user_id'])->delete();

        return response()->json([
            'success' => true,
            'message' => 'User form data purged.',
        ]);
    }

    private function resolveUserId(Request $request): ?string
    {
        $userId = $request->header('X-User-Id')
            ?? $request->query('user_id')
            ?? $request->input('user_id');

        if (!is_string($userId) || !Str::isUuid($userId)) {
            return null;
        }

        return $userId;
    }
}
