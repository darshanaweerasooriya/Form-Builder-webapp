<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;
use App\Models\FormSubmission;
use App\Models\FormFieldValue;

class FormController extends Controller
{
    public function index()
    {
        return response()->json(Form::with('fields')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'fields' => 'array',
        ]);

        $form = Form::create(['title' => $request->title]);

        if($request->has('fields')){
            foreach($request->fields as $order => $field){
                $form->fields()->create([
                    'label' => $field['label'],
                    'type' => $field['type'],
                    'required' => $field['required'] ?? false,
                    'options' => $field['options'] ?? null,
                    'order' => $order,
                ]);
            }
        }

        return response()->json($form->load('fields'), 201);
    }

    public function show($id)
    {
        return response()->json(Form::with('fields')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $form = Form::findOrFail($id);
        $form->update(['title' => $request->title]);

        if($request->has('fields')){
            $form->fields()->delete();
            foreach($request->fields as $order => $field){
                $form->fields()->create([
                    'label' => $field['label'],
                    'type' => $field['type'],
                    'required' => $field['required'] ?? false,
                    'options' => $field['options'] ?? null,
                    'order' => $order,
                ]);
            }
        }

        return response()->json($form->load('fields'));
    }

    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        $form->delete();
        return response()->json(['message' => 'Form deleted successfully']);
    }

    public function submit(Request $request, $id)
    {
        $form = Form::with('fields')->findOrFail($id);

        $data = $request->validate($this->buildValidationRules($form));

        $submission = FormSubmission::create(['form_id' => $form->id]);

        foreach($form->fields as $field){
            FormFieldValue::create([
                'submission_id' => $submission->id,
                'field_id' => $field->id,
                'value' => $request->input($field->id),
            ]);
        }

        return response()->json(['message' => 'Form submitted successfully', 'submission_id' => $submission->id], 201);
    }

    public function submissions($id)
    {
        $form = Form::findOrFail($id);
        return response()->json($form->submissions()->with('values.field')->get());
    }

    private function buildValidationRules($form)
    {
        $rules = [];
        foreach($form->fields as $field){
            $rule = [];
            if($field->required) $rule[] = 'required';
            if($field->type === 'email') $rule[] = 'email';
            $rules[$field->id] = $rule;
        }
        return $rules;
    }
}
