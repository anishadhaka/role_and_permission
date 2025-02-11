@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>NewsCategory Management</h2>
        </div>
        @can('newscategory-create')
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('newsCategory.create') }}"><i class="fa fa-plus"></i> Create New Blog</a>
        </div>
        @endcan
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
       <th>Meta Description</th>
       <th>Meta Keyword</th>
       <th>SEO Robat</th>
       @canany(['news-edit', 'news-delete'])
        <th width="280px">Action</th>
        @endcanany
   </tr>
   @foreach ($data as $key => $user)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->title }}</td>
        <td>{{ $user->meta_description }}</td>
        <td>{{ $user->meta_keyword }}</td>
        <td>{{ $user->seo_robat }}</td>

       

       
        <td>
             <a class="btn btn-info btn-sm" href="{{ route('newsCategory.show',$user->id) }}"><i class="fa-solid fa-list"></i> Show</a>
            @can('newscategory-edit')
             <a class="btn btn-primary btn-sm" href="{{ route('newsCategory.edit',$user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
             @endcan
             @can('newscategory-delete') 
             <form method="POST" action="{{ route('newsCategory.destroy', $user->id) }}" style="display:inline">
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
