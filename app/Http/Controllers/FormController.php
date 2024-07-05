<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormSubmission;

class FormController extends Controller
{
    public function showFormBySlug($slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();
        $fields = $form->fields;

        return view('public.form', compact('form', 'fields'));
    }

    public function submitForm(Request $request, $slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();
        $fields = $form->fields;

        $data = [];
        foreach ($fields as $field) {
            $fieldName = 'field_' . $field->id;
            $request->validate([
                $fieldName => $field->type == 'text' ? 'required|string' : ($field->type == 'number' ? 'required|numeric' : 'required|string'),
            ]);
            $data[$field->label] = $request->input($fieldName);
        }

        FormSubmission::create([
            'form_id' => $form->id,
            'data' => json_encode($data),
        ]);

        return redirect()->route('public.show_form', ['slug' => $slug])->with('success', 'Form submitted successfully!');
    }
}
