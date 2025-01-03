@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit News</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('news.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
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

<form method="POST" action="{{ route('news.update', $News->id) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $News->name }}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Category:</strong>
                <select name="category_id" class="form-control" >
                @foreach ($categories as $id => $title)
                   <option value="{{ $id }}">
                       {{ $title }}
                   </option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <input type="text" name="description" placeholder="description" class="form-control"  value="{{ $News->description }}">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <strong>Domain:</strong>
        <select name="domain" class="form-control">
            @foreach ($domains as $id => $domain_name) 
                <option value="{{ $id }}">
                    {{ $domain_name }}
                </option>
            @endforeach
        </select>
        @error('domain')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <strong>Language:</strong>
        <select name="language" class="form-control">
            @foreach ($languages as $id => $language_name) 
                <option value="{{$id }}">
                    {{ $language_name }}
                </option>
            @endforeach
        </select>
        @error('language')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Image:</strong>
                <input type="file" name="image" placeholder="image" class="form-control"  value="{{ $News->image }}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </div>
    </div>
</form>


@endsection
