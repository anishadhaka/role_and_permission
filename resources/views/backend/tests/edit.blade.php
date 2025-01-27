@extends('backend.layouts.app')

    @section('content')
    <title>Edit {{ ucfirst('tests') }}</title>
    
    <h2>Edit {{ ucfirst('tests') }}</h2>
    
    <form action="{{ route('tests.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('name') }}:</strong>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $item->name }}" required>
                            </div>
                        </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
    
    @endsection