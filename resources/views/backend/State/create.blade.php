@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add New State</h1>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- State Form -->
    <form action="{{ route('State.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="country_id" class="form-label">Country ID</label>
            <input type="number" name="country_id" id="country_id" class="form-control" value="{{ old('country_id') }}">
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="is_capital" class="form-label">Is Capital</label>
            <select name="is_capital" id="is_capital" class="form-control">
                <option value="0" {{ old('is_capital') == '0' ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('is_capital') == '1' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}">
        </div>

        <div class="mb-3">
            <label for="is_active" class="form-label">Is Active</label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="ourOperation" class="form-label">Operation</label>
            <select name="ourOperation" id="ourOperation" class="form-control">
                <option value="On" {{ old('ourOperation') == 'On' ? 'selected' : '' }}>On</option>
                <option value="Off" {{ old('ourOperation') == 'Off' ? 'selected' : '' }}>Off</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="created_date" class="form-label">Created Date</label>
            <input type="datetime-local" name="created_date" id="created_date" class="form-control" value="{{ old('created_date') }}">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('State.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
