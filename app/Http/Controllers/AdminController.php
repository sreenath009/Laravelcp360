<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;
use App\Jobs\SendFormCreatedNotification;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dashboard()
    {
        $forms = Form::all();
        return view('admin.dashboard', compact('forms'));
    }

    public function createForm()
    {
        return view('admin.create_form');
    }

    public function saveForm(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'fields.*.label' => 'required|string|max:255',
            'fields.*.type' => 'required|string|in:text,number,dropdown',
            'fields.*.options' => 'nullable|string',
        ]);
// echo"<pre>";print_r($validatedData);exit;
        $form = new Form();
        $form->title = $request->input('title');
        $form->slug = \Str::slug($request->input('title'));
        $form->save();

        foreach ($request->input('fields') as $fieldData) {
            $field = new FormField();
            $field->form_id = $form->id;
            $field->label = $fieldData['label'];
            $field->type = $fieldData['type'];
            if ($fieldData['type'] == 'dropdown') {
                $field->options = $fieldData['options'];
            }
            $field->save();
        }

        // Dispatch the email notification job
        SendFormCreatedNotification::dispatch($form);

        return redirect()->route('admin.dashboard')->with('success', 'Form created successfully!');
    }

    public function editForm(Form $form)
    {
        return view('admin.edit_form', compact('form'));
    }

    public function updateForm(Request $request, Form $form)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'fields.*.label' => 'required|string|max:255',
            'fields.*.type' => 'required|string|in:text,number,dropdown',
            'fields.*.options' => 'nullable|string',
        ]);

        $form->title = $request->input('title');
        $form->slug = \Str::slug($request->input('title'));
        $form->save();

        $form->fields()->delete();

        foreach ($request->input('fields') as $fieldData) {
            $field = new FormField();
            $field->form_id = $form->id;
            $field->label = $fieldData['label'];
            $field->type = $fieldData['type'];
            if ($fieldData['type'] == 'dropdown') {
                $field->options = $fieldData['options'];
            }
            $field->save();
        }

        return redirect()->route('admin.dashboard')->with('success', 'Form updated successfully!');
    }

    public function deleteForm(Form $form)
    {
        $form->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Form deleted successfully!');
    }

    public function deleteField(FormField $field)
    {
        $field->delete();
        return redirect()->back()->with('success', 'Field deleted successfully!');
    }
}
