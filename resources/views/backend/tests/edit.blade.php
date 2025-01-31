@extends('backend.layouts.app')

@section('content')
<h2>Edit {{ ucfirst('tests') }}</h2>

<form action="{{ route('tests.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('id') }}:</strong>
                                <input type="number" name="id" class="form-control" value="{{ $item->id }}">
                            </div>
                        </div><div class="col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('name') }}:</strong>
                                <select name="name" class="form-control">
                                    @foreach(json_decode('[]', true) as $key => $value)
                                        <option value="{{ $key }}" {{ $item->name == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><div class="col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('updated_at') }}:</strong>
                                <input type="date" name="updated_at" class="form-control" value="{{ $item->updated_at }}">
                            </div>
                        </div><div class="col-md-12">
                            <div class="form-group">
                                <strong>{{ ucfirst('created_at') }}:</strong>
                                <input type="date" name="created_at" class="form-control" value="{{ $item->created_at }}">
                            </div>
                        </div>

        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </div>
</form>
@endsection