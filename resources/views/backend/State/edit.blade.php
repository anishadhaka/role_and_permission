@extends('backend.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit State</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('State.update', $state->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="country_id" class="form-label">Country ID</label>
            <input type="number" name="country_id" id="country_id" class="form-control" value="{{ old('country_id', $state->country_id) }}">
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $state->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="is_capital" class="form-label">Is Capital</label>
            <select name="is_capital" id="is_capital" class="form-control">
                <option value="0" {{ old('is_capital', $state->is_capital) == '0' ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('is_capital', $state->is_capital) == '1' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $state->slug) }}">
        </div>

        <div class="mb-3">
            <label for="is_active" class="form-label">Is Active</label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="1" {{ old('is_active', $state->is_active) == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active', $state->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="ourOperation" class="form-label">Operation</label>
            <select name="ourOperation" id="ourOperation" class="form-control">
                <option value="On" {{ old('ourOperation', $state->ourOperation) == 'On' ? 'selected' : '' }}>On</option>
                <option value="Off" {{ old('ourOperation', $state->ourOperation) == 'Off' ? 'selected' : '' }}>Off</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="created_date" class="form-label">Created Date</label>
            <input type="datetime-local" name="created_date" id="created_date" class="form-control" value="">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('State.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
