@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Manage Permissions for Module: {{ $module->Title }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary mb-2" href="{{ route('modules.index') }}">Back to Modules</a>
        </div>
    </div>
</div>

<form id="permissionForm" method="POST" action="{{ route('permissions.save') }}">
    @csrf
    <input type="hidden" name="module_id" value="{{ $module->id }}">
    


    
    <div class="form-group mb-3">
        <label for="permissions">Select Permissions</label>
        <select name="permissions[]" id="permissions" class="form-control" multiple>
            @foreach ($allPermissions as $permission)
                <option value="{{ $permission->id }}" 
                    {{ in_array($permission->id, $modulePermissions) ? 'selected' : '' }}>
                    {{ $permission->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success">Save Permissions</button>
    </div>
</form>
@endsection
