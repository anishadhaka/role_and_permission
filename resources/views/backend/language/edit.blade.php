@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Language</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary mb-2" href="{{ route('language.index') }}">Back</a>
        </div>
    </div>
</div>

<form action="{{ route('language.update', $language->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Language Name:</strong>
                <input type="text" name="language_name" class="form-control" value="{{ $language->language_name }}" placeholder="Language Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Language Code:</strong>
                <input type="text" name="language_code" class="form-control" value="{{ $language->language_code }}" placeholder="Language Code">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
</form>
@endsection
