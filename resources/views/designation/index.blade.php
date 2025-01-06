@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>designation Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('designation.create') }}"><i class="fa fa-plus"></i> Create New designation</a>
        </div>
    </div>
</div>

@session('success')
    <div class="alert alert-success" role="alert"> 
        {{ $value }}
    </div>
@endsession

<table id="designationTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>designation Name</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
    <tbody>
       
    </tbody>
</table>
<script>
$(document).ready(function () {
    $('#designationTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('designation.index') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'designation_name', name: 'designation_name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

</script>
@endsection
