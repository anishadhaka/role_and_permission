@extends('backend.layouts.app')

 @section('content')
 <title>{{ ucfirst('tests') }} List</title>
 
 <div class="row">
     <div class="col-lg-12 margin-tb">
         <div class="pull-left">
             <h2>{{ ucfirst('tests') }} List</h2>
         </div>
         <div class="pull-right">
             <a class="btn btn-success mb-2" href="{{ route('tests.create') }}">
                 Add New
             </a>
         </div>
     </div>
 </div>
 
 <table class="table table-bordered">
     <thead>
         <tr>
             <th>{{ ucfirst('country') }}</th>
             <th>Actions</th>
         </tr>
     </thead>
     <tbody>
         @foreach($data as $row)
         <tr>
             <td>{{ $row->country }}</td>
             <td>
                 <a href="{{ route('tests.edit', $row->id) }}" class="btn btn-primary btn-sm">Edit</a>
                 <form action="{{ route('tests.destroy', $row->id) }}" method="POST" style="display:inline;">
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