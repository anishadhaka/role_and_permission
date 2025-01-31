@extends('backend.layouts.app')
@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Modules</h2>
        </div>
        <div class="pull-right">
            <form action="{{ route('recycle') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success mb-2">
                    Recycle
                </button>
            </form>
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
        <th>MVC</th>
        <th>Action</th>
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
        <td>
            <button class="btn btn-dark btn-sm" onclick="generateMVC({{ $user->id }})">MVC</button>
        </td>
        <td>
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




<!-- MVC Confirmation Modal -->
<div class="modal fade" id="mvcConfirmationModal" tabindex="-1" aria-labelledby="mvcConfirmationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mvcConfirmationLabel">Generate MVC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="mvcForm">
                    <label for="table-name" class="form-label">Select Table Name</label>
                    <select id="table-name" name="table_name" class="form-control" required>
                        <option value="">-- Select Table --</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmMVCButton" onclick="redirectToMVCPage()">Generate</button>

            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let selectedModuleId = null;

function openPermissionModal(moduleId) 
{
    $('#module_id').val(moduleId);
    $('#permissionForm').find('.permission-wrapper').remove();
    $.ajax({
        url: '/module/permissions/' + moduleId,
        method: 'GET',
        success: function(response) {
            if (response.permissions && response.permissions.length > 0) {
                response.permissions.forEach(function (permission) {
                    const uniqueId = 'permission-' + permission.id;
                    $('#permissionForm').append(createPermissionField(uniqueId, moduleId, permission.name, permission.id));
                });
            } else {
                addDefaultPermissionField(moduleId);
            }
        },
        error: function () {
            alert('Error fetching permissions. Please try again.');
            addDefaultPermissionField(moduleId);
        }
    });
}
function createPermissionField(uniqueId, moduleId, permissionName = '', permissionId = null) 
{
    return `
        <div class="permission-wrapper mt-3" id="${uniqueId}">
            <input type="hidden" name="module_id[]" value="${moduleId}">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Permission:</strong>
                    <input type="text" name="name[]" value="${permissionName}" placeholder="Title" class="form-control">
                </div>
                <button type="button" class="btn btn-danger mt-2" onclick="deletePermission('${uniqueId}', ${permissionId})">Delete</button>
            </div>
        </div>
    `;
}
function addDefaultPermissionField(moduleId) 
{
    const uniqueId = 'permission-' + Date.now();
    $('#permissionForm').append(createPermissionField(uniqueId, moduleId));
}
function add() 
{
    const uniqueId = 'permission-' + Date.now();
    const moduleId = $('#module_id').val();
    $('#permissionForm').append(createPermissionField(uniqueId, moduleId));
}
function save() 
{
    let isValid = true;
    $('#permissionForm input[name="name[]"]').each(function () {
        if (!$(this).val().trim()) {
            isValid = false;
            $(this).css('border', '2px solid red');
            return false;
        } else {
            $(this).css('border', '');
        }
    });
    if (!isValid) return;
    const formData = $('#permissionForm').serialize();
    $.ajax({
        url: '{{ route('modulesave') }}',
        method: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            alert(response.message);
            $('#permissionModal').modal('hide');
            location.reload();
        },
        error: function () {
            alert('Error saving permissions. Please try again.');
        }
    });
}
function deletePermission(uniqueId, permissionId = null)
{
    $(`#${uniqueId}`).remove();
    if ($('.permission-wrapper').length === 0) {
        const moduleId = $('#module_id').val();
        addDefaultPermissionField(moduleId);
    }
    if (permissionId) {
        $.ajax({
            url: `/module/permissions/${permissionId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                alert(response.message || 'Permission deleted successfully!');
            },
            error: function () {
                alert('Error deleting permission. Please try again.');
            }
        });
    }
}
// show popup box 
function generateMVC(moduleId) 
{
    selectedModuleId = moduleId;

    // Fetch table names from the server
    $.ajax({
       url: '{{ route("module.getTables") }}',
        method: 'GET',
        success: function(response) {
            const tableDropdown = $('#table-name');
            tableDropdown.empty(); // Clear previous options
            tableDropdown.append('<option value="">-- Select Table --</option>');

            if (response.tables && response.tables.length > 0) {
                response.tables.forEach((table) => {
                    const tableName = Object.values(table)[0]; // Extract table name
                    tableDropdown.append(`<option value="${tableName}">${tableName}</option>`);
                });
            } else {
                tableDropdown.append('<option value="">No Tables Available</option>');
            }

            $('#mvcConfirmationModal').modal('show');
        },
        error: function() {
            alert('Error fetching table names. Please try again.');
        }
    });
}

function redirectToMVCPage() {
    const tableName = $('#table-name').val();

    if (!tableName) {
        alert('Please select a table name before proceeding.');
        return;
    }

    if (!selectedModuleId) {
        alert('Module ID is not set. Please try again.');
        return;
    }

    // Redirect to the desired route with query parameters
    const url = `/mvc/generate?module_id=${selectedModuleId}&table_name=${encodeURIComponent(tableName)}`;
    window.location.href = url;
}




</script>

@endsection
