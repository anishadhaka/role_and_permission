@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Menu Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('menu.create') }}"><i class="fa fa-plus"></i> Create New Menu</a>
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
       <th>Id</th>
       <th>category</th>
       <th>permission</th>
       <th>AddMenu</th>
      

     
       <th width="280px">Action</th>
   </tr>
   @foreach ($data as $key => $menu)
    <tr>
        <td>{{  $menu->id  }}</td>
        <td>{{ $menu->category }}</td>
        <td>{{ $menu->permission }}</td>
       <td> <a href="{{ route('menu', $menu->id) }}"><i class="fa-solid fa-key"></i></a> </td>

        <td>
             <!-- <a class="btn btn-info btn-sm" href="{{ route('menu.show',$menu->id) }}"><i class="fa-solid fa-list"></i> Show</a> -->
             <a class="btn btn-primary btn-sm" href="{{ route('menu.edit',$menu->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
              <!-- <form method="POST" action="{{ route('menu.destroy', $menu->id) }}" style="display:inline">
                  @csrf
                  @method('DELETE')

                  <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
              </form> -->
        </td>
    </tr>
 @endforeach
</table>

{!! $data->links('pagination::bootstrap-5') !!}


@endsection