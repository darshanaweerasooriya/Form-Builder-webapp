<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;

class FormController extends Controller
{
    public function index()
    {
        return response()->json(Form::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $form = Form::create($validated);

        return response()->json($form, 201);
    }

    public function show($id)
    {
        $form = Form::find($id);
        if (!$form) {
            return response()->json(['message' => 'Form not found'], 404);
        }
        return response()->json($form);
    }

    public function update(Request $request, $id)
    {
        $form = Form::find($id);
        if (!$form) {
            return response()->json(['message' => 'Form not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $form->update($validated);
        return response()->json($form);
    }

    public function destroy($id)
    {
        $form = Form::find($id);
        if (!$form) {
            return response()->json(['message' => 'Form not found'], 404);
        }

        $form->delete();
        return response()->json(['message' => 'Form deleted successfully']);
    }
}
