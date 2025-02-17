@extends('backend.layouts.app')

@section('content')
<h2>Edit {{ ucfirst('tests') }}</h2>

<form action="{{ route('tests.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('name') }}:</strong>
                                <input type="textarea" name="name" class="form-control" value="{{ $item->name }}">
                            </div>
                        </div><div class="col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('city') }}:</strong>
                                <input type="file" name="city" class="form-control" value="{{ $item->city }}">
                            </div>
                        </div><div class="col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('country') }}:</strong>
                                <input type="select" name="country" class="form-control" value="{{ $item->country }}">
                            </div>
                        </div><div class="col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('state') }}:</strong>
                                <input type="email" name="state" class="form-control" value="{{ $item->state }}">
                            </div>
                        </div>

        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </div>
</form>
@endsection