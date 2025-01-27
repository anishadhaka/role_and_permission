@extends('backend.layouts.app')

    @section('content')
    <title>Add {{ ucfirst('tests') }}</title>
    
    <h2>Add {{ ucfirst('tests') }}</h2>
    
    <form action="{{ route('tests.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('name') }}:</strong>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </form>
    
    @endsection