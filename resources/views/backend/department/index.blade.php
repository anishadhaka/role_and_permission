@extends('backend.layouts.app')

@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

<!-- jQuery (necessary for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>department Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('department.create') }}"><i class="fa fa-plus"></i> Create New department</a>
        </div>
    </div>
</div>

@session('success')
    <div class="alert alert-success" role="alert"> 
        {{ $value }}
    </div>
@endsession

<table id="departmentTable" class="table table-bordered">
    <thead>
        <tr>
            <th>  Id</th>
            <th>department Name</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
    <tbody>
       
    </tbody>
</table>
<script>
$(document).ready(function () {
    $('#departmentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('department.index') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'department_name', name: 'department_name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

</script>





@endsection