@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Modules</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('module.create') }}">
                <i class="fa fa-plus"></i> Create New Module
            </a>
        </div>
    </div>
</div>

@session('success')
    <div class="alert alert-success" role="alert">
        {{ $value }}
    </div>
@endsession

<table class="table table-bordered">
    <tr>
        <th>id</th>
        <th>Title</th>
        <th>Parent</th>
        <th>Create date</th>
        <th>Update date</th>
        <th>Add Permission</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($data as $key => $user)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->Title }}</td>
        <td>{{ $user->parent_id }}</td>
        <td>{{ $user->created_at }}</td>
        <td>{{ $user->updated_at }}</td>
        <td>
            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#permissionModal" onclick="openPermissionModal({{ $user->id }})">
                Add Permission
            </button>
        </td>
        @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
                <label class="badge bg-success">{{ $v }}</label>
            @endforeach
        @endif
        </td>
        <td>
            <a class="btn btn-info btn-sm" href="{{ route('module.show', $user->id) }}"><i class="fa-solid fa-list"></i> Show</a>
            <a class="btn btn-primary btn-sm" href="{{ route('module.edit', $user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
            <form method="POST" action="{{ route('module.destroy', $user->id) }}" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{!! $data->links('pagination::bootstrap-5') !!}

<div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="permissionModalLabel">Manage Permissions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="permissionForm">
                    @csrf
                    <input type="hidden" name="module_id" id="module_id">
                    
                    <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permission Title:</strong>
                            <input type="text" name="permissions[]" placeholder="Title" class="form-control">
                        </div>
                    </div> -->

                 
                </form>
                <div class="form-group mt-3">
                        <button type="button" id="add-more" class="btn btn-info" onclick="add()">Add More</button>
                        <button type="button" id="save-permission" class="btn btn-success" onclick="save()">Save</button>
                        <!-- <button type="button" id="delete-permission" class="btn btn-danger" onclick="deleted()">Delete</button> -->
                    </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function openPermissionModal(moduleId) {
    $('#module_id').val(moduleId); 
    $('#permissionForm').find('.permission-wrapper').remove(); 

    $.ajax({
        url: '/module/permissions/' + moduleId,
        method: 'GET',
        success: function(response) {
            if (response.permissions && response.permissions.length > 0) {
                response.permissions.forEach(function(permission) {
                 
                    $('#permissionForm').append(`
                   
                        <div class="permission-wrapper mt-3">
                            <input type="hidden" name="module_id[]" value="${moduleId}">
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                <div class="form-group">
                                    <strong>Permission Title:</strong>
                                    <input type="text" name="name[]" value="${permission.name}" placeholder="Title" class="form-control">
                                </div>

                            </div>
                        </div>
                        
                    `);
                });
            }
        },
        error: function(xhr, status, error) {
            alert('Error fetching permissions. Please try again.');
        }
    });
}
    

function add() {
    var uniqueId = 'permission-' + Date.now();
    var moduleId = $('#module_id').val();
    console.log(moduleId);

    $('#permissionForm').append(`
   
        <div class="permission-wrapper mt-3" id="${uniqueId}">
            <input type="hidden" name="module_id[]" value="${moduleId}">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Permission :</strong>
                   
                    <input type="text" name="name[]"  placeholder="Title" class="form-control">
                </div>
                <button type="button" class="btn btn-danger" onclick="deleted('${uniqueId}')">Delete</button>
            </div>
        </div>
            <!-- Other form fields -->

    `);
}
function save() {
    var formData = $('#permissionForm').serialize(); 
    $.ajax({
        url: '{{ route('modulesave') }}', 
        method: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
        },
        success: function(response) {
            alert(response.message); 
            $('#permissionModal').modal('hide'); 
            location.reload(); 
        },
        error: function(xhr) {
            alert('Error saving permissions. Please check your input.');
        }
    });
}
    
function deleted(uniqueId)
{
   $('#' + uniqueId).remove();
}
</script>

@endsection
