@extends('layouts.app')

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
            <h2>Language Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('language.create') }}">
                <i class="fa fa-plus"></i> Create New Language
            </a>
        </div>
    </div>
</div>

{{-- Display success message if available --}}
@if (session('success'))
    <div class="alert alert-success" role="alert"> 
        {{ session('success') }}
    </div>
@endif

<table id="languageTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Language Name</th>
            <th>Language Code</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
    <tbody>
        {{-- Table rows will be populated by DataTables --}}
    </tbody>
</table>

{{-- DataTables Script --}}
<script>
    $(document).ready(function () {
        $('#languageTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('language.index') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'language_name', name: 'language_name' },
                { data: 'language_code', name: 'language_code' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>

@endsection
