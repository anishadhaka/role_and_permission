@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>State Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('State.create') }}"><i class="fa fa-plus"></i> Create New State</a>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table id="stateTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>State Name</th>
            <th>Country Id</th>
            <th>Action</th>

    </thead>
    <tbody>
       
    </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
$(document).ready(function () {
    $('#stateTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('State.index') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'country_id', name: 'country_id' },
            { data: 'action', name: 'action', orderable: false, searchable: false },


        ]
    });
});

</script>

@endsection
