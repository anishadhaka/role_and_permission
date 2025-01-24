@extends('backend.layouts.app')

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
        <select name="domain_id" class="form-control">
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
        <select name="language_id" class="form-control">
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
        <strong>Country:</strong>
        <select name="country_id" class="form-control">
            @foreach($country as $countries)
            <option value="{{$countries->id}}">
                {{$countries->name}}
            </option>
            @endforeach
        </select>

    </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <strong>Upload Image:</strong>
        <div class="d-flex flex-column align-items-center">
            @if ($News->image)
                <img src="{{ asset('images/' . $News->image) }}" alt="Uploaded Image" class="img-thumbnail mb-2" height="100" width="100">
            @endif
            <div class="input-group">
                <input type="text" id="image_label" class="form-control" name="image" value="{{ old('image', $News->image) }}" placeholder="Select an image..." aria-label="Image">
                <button class="btn btn-outline-secondary" type="button" id="button-image">Select</button>
            </div>
        </div>
    </div>
    @error('image')<p class="text-danger">{{ $message }}</p>@enderror
</div>


        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </div>
    </div>
</form>


@endsection