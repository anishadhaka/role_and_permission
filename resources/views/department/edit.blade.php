@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit department</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary mb-2" href="{{ route('department.index') }}">Back</a>
        </div>
    </div>
</div>

<form action="{{ route('department.update', $department->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>department Name:</strong>
                <input type="text" name="department_name" class="form-control" value="{{ $department->department_name }}" placeholder="department Name">
            </div>
        </div>
    <button type="submit" class="btn btn-success">Update</button>
</form>
@endsection
