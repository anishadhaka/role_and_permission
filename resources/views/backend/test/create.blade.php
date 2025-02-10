@extends('backend.layouts.app')
 
 @section('content')
 <title>Add {{ ucfirst('test') }}</title>
 
 <h2>Add {{ ucfirst('test') }}</h2>
 
 <form action="{{ route('test.store') }}" method="POST">
     @csrf
     <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12">
                             <div class="form-group">
                                 <strong>{{ ucfirst('id') }}:</strong>
                                 <input type="number" name="id" id="id" class="form-control" required>
                             </div>
                         </div><div class="col-xs-12 col-sm-12 col-md-12">
                             <div class="form-group">
                                 <strong>{{ ucfirst('name') }}:</strong>
                                 <input type="select" name="name" id="name" class="form-control" required>
                             </div>
                         </div><div class="col-xs-12 col-sm-12 col-md-12">
                             <div class="form-group">
                                 <strong>{{ ucfirst('updated_at') }}:</strong>
                                 <input type="date" name="updated_at" id="updated_at" class="form-control" required>
                             </div>
                         </div><div class="col-xs-12 col-sm-12 col-md-12">
                             <div class="form-group">
                                 <strong>{{ ucfirst('created_at') }}:</strong>
                                 <input type="date" name="created_at" id="created_at" class="form-control" required>
                             </div>
                         </div>
 
         <div class="col-xs-12 col-sm-12 col-md-12 text-center">
             <button type="submit" class="btn btn-success">Save</button>
         </div>
     </div>
 </form>
 
 @endsection