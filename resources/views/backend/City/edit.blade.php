@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit City</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('City.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
</div>

<!-- Display Success Messages -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- City Form -->
<form action="{{ route('City.update', $city->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">City Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $city->name }}" required>
            </div>

            <div class="form-group">
                <label for="country_id">Country ID</label>
                <input type="number" name="country_id" id="country_id" class="form-control" value="{{ $city->country_id }}" required>
            </div>

            <div class="form-group">
                <label for="state_id">State ID</label>
                <input type="number" name="state_id" id="state_id" class="form-control" value="{{ $city->state_id }}" required>
            </div>

            <div class="form-group">
                <label for="is_capital">Is Capital</label>
                <select name="is_capital" id="is_capital" class="form-control">
                    <option value="0" {{ $city->is_capital == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $city->is_capital == 1 ? 'selected' : '' }}>Yes</option>
                </select>
            </div>

            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ $city->slug }}">
            </div>

            <div class="form-group">
                <label for="intro">Intro</label>
                <textarea name="intro" id="intro" class="form-control">{{ $city->intro }}</textarea>
            </div>

            <div class="form-group">
                <label for="time_to_visit">Time to Visit</label>
                <input type="text" name="time_to_visit" id="time_to_visit" class="form-control" value="{{ $city->time_to_visit }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $city->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="thumb_image">Thumbnail Image</label>
                <input type="file" name="thumb_image" id="thumb_image" class="form-control">
            </div>

            <div class="form-group">
                <label for="banner_image">Banner Image</label>
                <input type="file" name="banner_image" id="banner_image" class="form-control">
            </div>

            <div class="form-group">
                <label for="currency">Currency</label>
                <input type="text" name="currency" id="currency" class="form-control" value="{{ $city->currency }}">
            </div>

            <div class="form-group">
                <label for="language">Language</label>
                <input type="text" name="language" id="language" class="form-control" value="{{ $city->language }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="latlogname">Latitude/Longitude Name</label>
                <input type="text" name="latlogname" id="latlogname" class="form-control" value="{{ $city->latlogname }}">
            </div>

            <div class="form-group">
                <label for="latlogaddress">Latitude/Longitude Address</label>
                <input type="text" name="latlogaddress" id="latlogaddress" class="form-control" value="{{ $city->latlogaddress }}">
            </div>

            <div class="form-group">
                <label for="iso_code">ISO Code</label>
                <input type="text" name="iso_code" id="iso_code" class="form-control" value="{{ $city->iso_code }}">
            </div>

            <div class="form-group">
                <label for="seo_title">SEO Title</label>
                <textarea name="seo_title" id="seo_title" class="form-control">{{ $city->seo_title }}</textarea>
            </div>

            <div class="form-group">
                <label for="meta_keyword">Meta Keywords</label>
                <textarea name="meta_keyword" id="meta_keyword" class="form-control">{{ $city->meta_keyword }}</textarea>
            </div>

            <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea name="meta_description" id="meta_description" class="form-control">{{ $city->meta_description }}</textarea>
            </div>

            <div class="form-group">
                <label for="lat">Latitude</label>
                <input type="text" name="lat" id="lat" class="form-control" value="{{ $city->lat }}">
            </div>

            <div class="form-group">
                <label for="log">Longitude</label>
                <input type="text" name="log" id="log" class="form-control" value="{{ $city->log }}">
            </div>

            <div class="form-group">
                <label for="is_active">Is Active</label>
                <select name="is_active" id="is_active" class="form-control">
                    <option value="1" {{ $city->is_active == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ $city->is_active == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ourOperation">Our Operation</label>
                <select name="ourOperation" id="ourOperation" class="form-control">
                    <option value="On" {{ $city->ourOperation == 'On' ? 'selected' : '' }}>On</option>
                    <option value="Off" {{ $city->ourOperation == 'Off' ? 'selected' : '' }}>Off</option>
                </select>
            </div>

            <div class="form-group">
                <label for="lang">Language</label>
                <input type="text" name="lang" id="lang" class="form-control" value="{{ $city->lang }}">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update City</button>
            </div>
        </div>
    </div>
</form>
@endsection
