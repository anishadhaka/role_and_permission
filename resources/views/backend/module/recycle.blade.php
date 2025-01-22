@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Recycle Modules</h2>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Parent</th>
            <th>Create Date</th>
            <th>Update Date</th>
            <!-- <th>Add Permission</th>
            <th>MVC</th> -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $user)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $user->Title }}</td>
                <td>{{ $user->parent_id }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>
                <!-- <td>
                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#permissionModal" onclick="openPermissionModal({{ $user->id }})">
                        Add Permission
                    </button>
                </td> -->
                <!-- <td>
                    <button class="btn btn-dark btn-sm" onclick="generateMVC({{ $user->id }})">MVC</button>
                </td> -->
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('module.edit', $user->id) }}">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('module.destroy', $user->id) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </form>

                    <form method="POST" action="{{ route('module.recover', $user->id) }}" style="display:inline;">
                      @csrf
                      @method('PUT') <!-- This specifies the PUT method -->
                      <button type="submit" class="btn btn-success btn-sm">
                          <i class="fa-solid fa-undo"></i> Restore
                      </button>
                    </form>


                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{!! $data->links('pagination::bootstrap-5') !!}
@endsection
