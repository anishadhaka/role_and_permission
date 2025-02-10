@extends('backend.layouts.app')

 @section('content')
 <title>{{ ucfirst('test') }} List</title>
 
 <div class="row">
     <div class="col-lg-12 margin-tb">
         <div class="pull-left">
             <h2>{{ ucfirst('test') }} List</h2>
         </div>
         <div class="pull-right">
             <a class="btn btn-success mb-2" href="{{ route('test.create') }}">
                 Add New
             </a>
         </div>
     </div>
 </div>
 
 <table class="table table-bordered">
     <thead>
         <tr>
             <th>{{ ucfirst('name') }}</th>
             <th>Actions</th>
         </tr>
     </thead>
     <tbody>
         @foreach($data as $row)
         <tr>
             <td>{{ $row->name }}</td>
             <td>
                 <a href="{{ route('test.edit', $row->id) }}" class="btn btn-primary btn-sm">Edit</a>
                 <form action="{{ route('test.destroy', $row->id) }}" method="POST" style="display:inline;">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                 </form>
             </td>
         </tr>
         @endforeach
     </tbody>
 </table>
 
 @endsection