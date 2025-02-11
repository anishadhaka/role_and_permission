@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Pages Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('pages.create') }}"><i class="fa fa-plus"></i> Create New Blog</a>
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
       <th>Title</th>
       <th>Description</th>
       @canany(['pages-edit', 'pages-delete'])
        <th width="280px">Action</th>
        @endcanany
   </tr>
   @foreach ($data as $key => $pages)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $pages->title }}</td>
        <td>{{ $pages->description }}</td>

       

       
        <td>
             <a class="btn btn-info btn-sm" href="{{ route('pages.show',$pages->id) }}"><i class="fa-solid fa-list"></i> Show</a>
             @can('pages-edit')
             <a class="btn btn-primary btn-sm" href="{{ route('pages.edit',$pages->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
             @endcan
             @can('pages-delete') 
             <form method="POST" action="{{ route('pages.destroy', $pages->id) }}" style="display:inline">
                  @csrf
                  @method('DELETE')

                  <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
              </form>
              @endcan
        </td>
    </tr>
 @endforeach
</table>

{!! $data->links('pagination::bootstrap-5') !!}


@endsection