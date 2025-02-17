@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit designation</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary mb-2" href="{{ route('designation.index') }}">Back</a>
        </div>
    </div>
</div>

<form action="{{ route('designation.update', $designation->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>designation Name:</strong>
                <input type="text" name="designation_name" class="form-control" value="{{ $designation->designation_name }}" placeholder="designation Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Department :</strong>
                <select name="department_id" class="form-control">
                @foreach($department as $id=>$department_name )
                <option value="{{$id}}">
                      {{$department_name}}
                </option>
                @endforeach
               </select>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <strong>Level : </strong>
        <select name="level" class="form-control">
            <option>Level 1</option>
            <option>Level 2</option>
            <option>Level 3</option>
            <option>Level 4</option>
    </select>
    </div>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
</form>
@endsection