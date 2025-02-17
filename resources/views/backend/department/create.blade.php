@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New department</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary mb-2" href="{{ route('department.index') }}">Back</a>
        </div>
    </div>
</div>

<form action="{{ route('department.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>department Name:</strong>
                <input type="text" name="department_name" class="form-control" placeholder="department Name">
            </div>
        </div>
       
    </div>
    <button type="submit" class="btn btn-success">Save</button>
</form>
@endsection