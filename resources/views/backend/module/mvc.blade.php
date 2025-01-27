@extends('backend.layouts.app')

@section('content')
<div class="container">
    <h2>Generate MVC</h2>
    <p>Module ID: {{ $moduleId }}</p>
    <p>Table Name: {{ $tableName }}</p>

    <form action="{{ route('mvc.generate.mvc') }}" method="POST">
        @csrf
        <div class="form-group">
            <h4>Select Columns</h4>
            @foreach($columns as $column)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $column }}" id="column_{{ $column }}" name="columns[]">
                    <label class="form-check-label" for="column_{{ $column }}">
                        {{ $column }}
                    </label>
                </div>
            @endforeach
        </div>
        <input type="hidden" name="tableName" value="{{ $tableName }}">
        <button type="submit" class="btn btn-primary mt-3">Generate MVC</button>
    </form>
</div>
@endsection
