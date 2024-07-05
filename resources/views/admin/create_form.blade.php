
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Form</h1>
    <form class="form" method="POST" action="{{ route('admin.save_form') }}">
        @csrf
        <label for="title">Form Title:</label>
        <input type="text" class="form-control" id="title" name="title" required>
        
        <div id="fields">
            <fieldset>
                <legend>Form Fields</legend>
                <div class="field">
                    <label for="fields-0-label">Label:</label>
                    <input type="text" class="form-control" id="fields-0-label" name="fields[0][label]" required>
                    
                    <label for="fields-0-type">Type:</label>
                    <select id="fields-0-type" class="form-control" name="fields[0][type]" required>
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="dropdown">Dropdown</option>
                    </select>
                    
                    <div id="fields-0-options" style="display: none;">
                        <label for="fields-0-options">Options (comma-separated):</label>
                        <input type="text" class="form-control" id="fields-0-options" name="fields[0][options]">
                    </div>
                </div>
            </fieldset>
        </div>

        <button type="button"  class="btn btn-secondary mt-3" onclick="addField()">Add Field</button>
        <button type="submit"  class="btn btn-primary mt-3 ms-3">Save Form</button>
    </form>
</div>

<script>
    let index = 1;

    function addField() {
    // console.log('hi');
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
        // console.log('hlo');
        if (event.target && event.target.matches('select')) {
            const index = event.target.id.split('-')[1];
            // console.log('index',index);
            if (event.target.value === 'dropdown') {
                 // console.log('hi');
                document.getElementById(`fields-${index}-options`).style.display = 'block';
            } else {
                document.getElementById(`fields-${index}-options`).style.display = 'none';
            }
        }
    });
</script>
@endsection
