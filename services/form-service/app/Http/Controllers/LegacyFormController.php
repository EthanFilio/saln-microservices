<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $form = $user->forms()->latest()->first();
        
        return view('dashboard', compact('form'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'form_data' => 'required|array',
        ]);

        $user = Auth::user();
        $user->last_activity_at = now();
        $user->save();

        $form = $user->forms()->latest()->first();
        
        if ($form) {
            $form->update([
                'form_data' => $request->form_data,
                'status' => 'draft',
            ]);
        } else {
            $form = $user->forms()->create([
                'form_data' => $request->form_data,
                'status' => 'draft',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Form saved successfully.',
        ]);
    }

    public function exportJson()
    {
        $user = Auth::user();
        $form = $user->forms()->latest()->first();
        
        if (!$form) {
            return response()->json([
                'error' => 'No form data to export.',
            ], 404);
        }

        return response()->json($form->form_data);
    }

    public function importJson(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:json',
        ]);

        $content = file_get_contents($request->file('file')->getRealPath());
        $data = json_decode($content, true);

        if (!$data) {
            return back()->withErrors(['file' => 'Invalid JSON file.']);
        }

        $user = Auth::user();
        $user->last_activity_at = now();
        $user->save();

        $form = $user->forms()->latest()->first();
        
        if ($form) {
            $form->update([
                'form_data' => $data,
                'status' => 'draft',
            ]);
        } else {
            $form = $user->forms()->create([
                'form_data' => $data,
                'status' => 'draft',
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Form data imported successfully.');
    }

    public function newEntry()
    {
        $user = Auth::user();
        $user->last_activity_at = now();
        $user->save();

        // Archive current form
        $currentForm = $user->forms()->latest()->first();
        if ($currentForm) {
            $currentForm->update(['status' => 'archived']);
        }

        return redirect()->route('dashboard')->with('success', 'New form entry started.');
    }

    public function generatePdf()
    {
        $user = Auth::user();
        $form = $user->forms()->latest()->first();
        
        if (!$form) {
            return back()->withErrors(['error' => 'No form data to generate PDF.']);
        }

        $user->last_activity_at = now();
        $user->save();

        // TODO: Implement PDF generation logic using the template_saln.json structure
        // This would use a library like DomPDF or Snappy to generate the official SALN PDF
        
        return back()->with('info', 'PDF generation coming soon.');
    }
}
