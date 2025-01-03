@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Language</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary mb-2" href="{{ route('language.index') }}">Back</a>
        </div>
    </div>
</div>

<form action="{{ route('language.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Language Name:</strong>
                <input type="text" name="language_name" class="form-control" placeholder="Language Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Language Code:</strong>
                <input type="text" name="language_code" class="form-control" placeholder="Language Code">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
</form>
@endsection
