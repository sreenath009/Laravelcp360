@extends('layouts.app')

@section('content')
    <div class="container">
    @if(auth()->user()->is_admin)
        <h1>Admin Dashboard</h1>
        @elseif(!auth()->user()->is_admin)
        <h1>Hello! {{auth()->user()->name}}</h1>
        @endif
        @if(auth()->user()->is_admin)
        <a href="{{ route('admin.create_form') }}" class="btn btn-primary mb-3">Create New Form</a>
        <ul>
            @endif
        @foreach ($forms as $form)
            <li>{{ $form->title }} - <a href="{{ route('public.show_form', ['slug' => $form->slug]) }}" class="btn btn-success">View Form</a></li>
        @endforeach
    </ul>
    @if(auth()->user()->is_admin)
        @if (count($forms) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($forms as $form)
                        <tr>
                            <td>{{ $form->title }}</td>
                            <td>{{ $form->slug }}</td>
                            <td>
                                <a href="{{ route('admin.edit_form', ['form' => $form->id]) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('admin.delete_form', ['form' => $form->id]) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger ms-3" onclick="return confirm('Are you sure you want to delete this form?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No forms found.</p>
        @endif
        @endif
    </div>
@endsection