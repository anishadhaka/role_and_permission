@extends('backend.layouts.app')
@section('content')
<style>
    .searchbar .search-container button {
  /* float: right;
  padding: 6px 10px; */
  /* margin-top: 8px; */
  margin-right: 16px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
  }
  .searchbar .search-container {
    float: right;
  }
  @media screen and (max-width: 600px) {
    .searchbar .search-container {
      float: none;
    }
    .searchbar input[type=text], .searchbar .search-container button {
      /* float: none; */
      /* display: block; */
      /* text-align: left; */
      /* width: 100%; */
      /* margin: 0; */
      /* padding: 14px; */
    }
    .searchbar input[type=text] {
      border: 1px solid #ccc;  
    }
  }
</style>
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>BlogCategory Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('blogCategory.create') }}"><i class="fa fa-plus"></i> Create New Blog</a>
            <div class="searchbar">
          <div class="search-container">
            <form action="">
              <input type="text" placeholder="Search.." name="search">
              <button type="submit"><i class="fa fa-search"></i></button>
            </form>
           </div>
           </div>
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
       <th>Meta Description</th>
       <th>Meta Keyword</th>
       <th>SEO Robat</th>
       <th width="280px">Action</th>
   </tr>
   @foreach ($data as $key => $user)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->title }}</td>
        <td>{{ $user->meta_description }}</td>
        <td>{{ $user->meta_keyword }}</td>
        <td>{{ $user->seo_robat }}</td>

       

       
        <td>
             <a class="btn btn-info btn-sm" href="{{ route('blogCategory.show',$user->id) }}"><i class="fa-solid fa-list"></i> Show</a>
             <a class="btn btn-primary btn-sm" href="{{ route('blogCategory.edit',$user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
              <form method="POST" action="{{ route('blogCategory.destroy', $user->id) }}" style="display:inline">
                  @csrf
                  @method('DELETE')

                  <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
              </form>
        </td>
    </tr>
 @endforeach
</table>

{!! $data->links('pagination::bootstrap-5') !!}


@endsection
