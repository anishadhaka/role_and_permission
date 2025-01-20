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
            <h2>Domain Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('domain.create') }}"><i class="fa fa-plus"></i> Create New domain</a>
        </div>
    </div>
</div>

@session('success')
    <div class="alert alert-success" role="alert"> 
        {{ $value }}
    </div>
@endsession

<table id="domainTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Domain Name</th>
            <th>Company Name</th>
            <th>Server Address</th>
            <th>Port</th>
            <th>Authentication</th>
            <th>User Name</th>
            <th>To Mail ID</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
    <tbody>
       
    </tbody>
</table>
<script>
$(document).ready(function () {
    $('#domainTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('domain.index') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'domain_name', name: 'domain_name' },
            { data: 'company_name', name: 'company_name' },
            { data: 'server_address', name: 'server_address' },
            { data: 'port', name: 'port' },
            { data: 'authentication', name: 'authentication' },
            { data: 'user_name', name: 'user_name' },
            { data: 'to_mail_id', name: 'to_mail_id',orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

</script>





@endsection
