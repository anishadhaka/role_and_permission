@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('module.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
</div>

@if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
         @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
         @endforeach
      </ul>
    </div>
@endif

<form method="POST" action="{{ route('module.store') }}">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                <input type="text" name="Title" placeholder="Title" class="form-control">
            </div>
        </div>
        <!-- <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
        <strong>Title:</strong>
        <select name="Title" class="form-control">    
            @foreach ($categories as $key => $dataGroup)
                <optgroup label="{{ ucfirst($key) }}">
                    @foreach ($dataGroup as $id => $title)
                        <option value="{{ $title }}">
                            {{ $title }}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
         </select>
        </div>
     </div> -->
        <!-- <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Parent:</strong>
                <input type="text" name="parent_id" placeholder="parent_id" class="form-control">
            </div>
        </div> -->
        <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <strong>Parent:</strong>
        <select name="parent_id" class="form-control">
            <option value="0">Select Parent</option> 
            @foreach ($categories as $key => $dataGroup)
                @php
                    $firstId = collect($dataGroup)->keys()->first(); 
                @endphp
                <option value="{{ $firstId }}">{{ ucfirst($key) }}</option>
            @endforeach
        </select>
    </div>
</div>
       

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </div>
    </div>
</form>


@endsection
