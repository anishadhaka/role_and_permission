@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Blog</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('blog.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
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

<form method="POST" action="{{ route('blog.store') }}">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" placeholder="Name" class="form-control">
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
                <strong>Content:</strong>
                <textarea name="content" placeholder="Content" class="form-control">{{ old('content') }}</textarea>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <strong>Domain:</strong>
        <select name="domain_id" class="form-control">
            @foreach ($domains as $id => $domain_name) 
                <option value="{{ $id }}" >
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
                <option value="{{ $id }}" >
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
        <strong>Status:</strong>  
        <select name="status_id" class="form-control">
            @foreach ($status as $id => $status_name) 
                <option value="{{ $id }}" {{ old('status_id', 1) == $id ? 'selected' : '' }}>
                    {{ $status_name }}
                </option>
            @endforeach
        </select>
        @error('status')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <strong>Country:</strong>
        <select name="country_id" id="country" class="form-control">
            <option value="">Select Country</option>
            @foreach ($country as $id => $name)
                <option value="{{ $id }}">{{ $name->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <strong>State:</strong>
        <select name="state_id" id="state" class="form-control">
            <option value="">Select State</option>
        </select>
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <strong>City:</strong>
        <select name="city_id" id="city" class="form-control">
            <option value="">Select City</option>
        </select>
    </div>
</div>



        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group">
        <strong>image:</strong>

                <input type="text" id="image_label" class="form-control" name="image" value="" placeholder="Select an image..." aria-label="Image">
                <button class="btn btn-outline-secondary" type="button" id="button-image">Select</button>
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <label>
            <input type="checkbox" name="stay_on_page" value="1"> Stay on this page after submitting
        </label>
    </div>
</div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#country').change(function() {
            var country_id = $(this).val();
            console.log(country_id);
            if (country_id) {
                $.ajax({
                    url: '/get-states/' + country_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#state').empty().append('<option value="">Select State</option>');
                        $('#city').empty().append('<option value="">Select City</option>');
                        $('#state-container').show(); // Show state dropdown
                        $('#city-container').hide(); // Hide city dropdown until a state is selected

                        $.each(data, function(id, name) {
                            $('#state').append('<option value="' + id + '">' + name + '</option>');
                        });
                    }
                });
            } else {
                $('#state-container').hide(); // Hide state dropdown if no country is selected
                $('#city-container').hide(); // Hide city dropdown as well
                $('#state').empty().append('<option value="">Select State</option>');
                $('#city').empty().append('<option value="">Select City</option>');
            }
        });

        $('#state').change(function() {
            var state_id = $(this).val();
            if (state_id) {
                $.ajax({
                    url: '/get-cities/' + state_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#city').empty().append('<option value="">Select City</option>');
                        $('#city-container').show(); // Show city dropdown

                        $.each(data, function(id, name) {
                            $('#city').append('<option value="' + id + '">' + name + '</option>');
                        });
                    }
                });
            } else {
                $('#city-container').hide(); // Hide city dropdown if no state is selected
                $('#city').empty().append('<option value="">Select City</option>');
            }
        });
    });
</script>

@endsection