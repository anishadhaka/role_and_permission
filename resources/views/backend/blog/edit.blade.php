@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Blog</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('blog.index') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('blog.update', $blog->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" placeholder="Name" class="form-control" value="{{ old('name', $blog->name) }}">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Category:</strong>
                <select name="category_id" class="form-control">
                    @foreach ($categories as $id => $title)
                        <option value="{{ $id }}" {{ $blog->category_id == $id ? 'selected' : '' }}>
                            {{ $title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Content:</strong>
                <textarea name="content" class="form-control" placeholder="Content">{{ old('content', $blog->content) }}</textarea>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Domain:</strong>
                <select name="domain_id" class="form-control">
                    @foreach ($domains as $id => $domain_name)
                        <option value="{{ $id }}" {{ $blog->domain_id == $id ? 'selected' : '' }}>
                            {{ $domain_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Language:</strong>
                <select name="language_id" class="form-control">
                    @foreach ($languages as $id => $language_name)
                        <option value="{{ $id }}" {{ $blog->language_id == $id ? 'selected' : '' }}>
                            {{ $language_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status:</strong>
                <select name="status_id" class="form-control">
                    @foreach ($status as $id => $status_name)
                        <option value="{{ $id }}" {{ $blog->status_id == $id ? 'selected' : '' }}>
                            {{ $status_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Country:</strong>
                <select name="country_id" class="form-control">
                    @foreach ($country as $id => $name)
                        <option value="{{ $id }}" {{ $blog->country_id == $id ? 'selected' : '' }}>
                            {{ $name->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Upload Image:</strong>
                <div class="d-flex flex-column align-items-center">
                    <img src="{{ asset('images/' . $blog->image) }}" alt="Uploaded Image" class="img-thumbnail mb-2" height="100" width="100">
                    <div class="input-group">
                        <input type="text" id="image_label" class="form-control" name="news_image" value="{{ old('news_image', $blog->image) }}" placeholder="Select an image..." aria-label="Image">
                        <button class="btn btn-outline-secondary" type="button" id="button-image">Select</button>
                    </div>
                </div>
            </div>
            @error('image')<p class="text-danger">{{ $message }}</p>@enderror
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3">
                <i class="fa-solid fa-floppy-disk"></i> Submit
            </button>
        </div>
    </div>
</form>

<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();
            const width = 600;
            const height = 400;
            const left = (window.screen.width / 2) - (width / 2);
            const top = (window.screen.height / 2) - (height / 2);
            window.open('/file-manager/fm-button', 'fm', `width=${width},height=${height},top=${top},left=${left}`);
        });
    });

    function fmSetLink(url) {
        document.getElementById('image_label').value = url.replace(/^https?:\/\/[^\/]+\//, '');
    }

    CKEDITOR.replace('content', {
        filebrowserImageBrowseUrl: '/file-manager/ckeditor'
    });
</script>

@endsection
