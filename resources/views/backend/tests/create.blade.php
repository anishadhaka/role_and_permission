@extends('backend.layouts.app')

@section('content')
<title>Add {{ ucfirst('tests') }}</title>

<h2>Add {{ ucfirst('tests') }}</h2>

<form action="{{ route('tests.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('name') }}:</strong>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div><div class="col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('city') }}:</strong>
                                <input type="select" name="city" class="form-control" required>
                            </div>
                        </div><div class="col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('country') }}:</strong>
                                <input type="select" name="country" class="form-control" required>
                            </div>
                        </div><div class="col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('state') }}:</strong>
                                <input type="select" name="state" class="form-control" required>
                            </div>
                        </div>

        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </div>
</form>
@endsection