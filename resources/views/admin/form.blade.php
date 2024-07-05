@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $form->title }}</h1>
    <form method="POST" action="{{ route('public.submit_form', ['slug' => $form->slug]) }}">
        @csrf
        @foreach ($fields as $field)
            <label>{{ $field->label }}</label>
            @if ($field->type === 'text')
                <input type="text" class="form-control" name="{{ $field->id }}" required>
            @elseif ($field->type === 'number')
                <input type="number" class="form-control" name="{{ $field->id }}" required>
            @elseif ($field->type === 'dropdown')
                <select name="{{ $field->id }}" class="form-control" required>
                    @foreach (explode(',', $field->options) as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            @endif
        @endforeach

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection