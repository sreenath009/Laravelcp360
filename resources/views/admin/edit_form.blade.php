@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Form</h1>
    <form method="POST" action="{{ route('admin.update_form', ['form' => $form->id]) }}">
        @csrf
        <label for="title">Form Title:</label>
        <input type="text" id="title" name="title" value="{{ $form->title }}" required>
        
        <div id="fields">
            <fieldset>
                <legend>Form Fields</legend>
                @foreach ($form->fields as $index => $field)
                    <div class="field">
                        <label for="fields-{{ $index }}-label">Label:</label>
                        <input type="text" id="fields-{{ $index }}-label" name="fields[{{ $index }}][label]" value="{{ $field->label }}" required>
                        
                        <label for="fields-{{ $index }}-type">Type:</label>
                        <select id="fields-{{ $index }}-type" name="fields[{{ $index }}][type]" required>
                            <option value="text" {{ $field->type == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="number" {{ $field->type == 'number' ? 'selected' : '' }}>Number</option>
                            <option value="dropdown" {{ $field->type == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                        </select>
                        
                        <div id="fields-{{ $index }}-options" style="{{ $field->type == 'dropdown' ? 'display: block;' : 'display: none;' }}">
                            <label for="fields-{{ $index }}-options">Options (comma-separated):</label>
                            <input type="text" id="fields-{{ $index }}-options" name="fields[{{ $index }}][options]" value="{{ $field->options }}">
                        </div>
                        
                        <button type="button" onclick="deleteField({{ $field->id }})">Delete Field</button>
                    </div>
                @endforeach
            </fieldset>
        </div>

        <button type="button" onclick="addField()">Add Field</button>
        <button type="submit">Update Form</button>
    </form>
</div>

<script>
    let index = {{ count($form->fields) }};

    function addField() {
        const template = `
            <div class="field">
                <label for="fields-${index}-label">Label:</label>
                <input type="text" id="fields-${index}-label" name="fields[${index}][label]" required>
                
                <label for="fields-${index}-type">Type:</label>
                <select id="fields-${index}-type" name="fields[${index}][type]" required>
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="dropdown">Dropdown</option>
                </select>
                
                <div id="fields-${index}-options" style="display: none;">
                    <label for="fields-${index}-options">Options (comma-separated):</label>
                    <input type="text" id="fields-${index}-options" name="fields[${index}][options]">
                </div>
            </div>
        `;
        document.getElementById('fields').insertAdjacentHTML('beforeend', template);
        index++;
    }

    document.addEventListener('change', function(event) {
        if (event.target && event.target.matches('select')) {
            const index = event.target.id.split('-')[1];
            if (event.target.value === 'dropdown') {
                document.getElementById(`fields-${index}-options`).style.display = 'block';
            } else {
                document.getElementById(`fields-${index}-options`).style.display = 'none';
            }
        }
    });

    function deleteField(fieldId) {
        const form = new FormData();
        form.append('_token', '{{ csrf_token() }}');
        form.append('_method', 'POST');
        fetch(`/admin/fields/${fieldId}/delete`, {
            method: 'POST',
            body: form
        }).then(() => {
            location.reload();
        });
    }
</script>
@endsection