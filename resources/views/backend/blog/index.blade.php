@extends('backend.layouts.app')

@section('content')
<style>
.searchbar .search-container button {
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

    .searchbar input[type=text] {
        border: 1px solid #ccc;
    }
}
</style>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Blog Management</h2>
        </div>
        <div class="pull-right">
        @can('blog-create')
            <a class="btn btn-success mb-2" href="{{ route('blog.create') }}"><i class="fa fa-plus"></i> Create New
                Blog</a>
                @endcan
            <!-- <div class="language-picker mb-1">
                <form action="{{ route('blog.index') }}" method="GET" class="language-picker__form" style="display:flex;margin-left:700px;margin-top:-50px;">
                    <label for="language-picker-select" style="font-weight:bold;margin-top:7px; padding:2px;">Language</label>
                    <select name="language" class="form-control" style="width:120px;height:40px;" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language }}">{{ $language }}</option>
                        @endforeach
                    </select>
                </form>
            </div> -->

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

<table class="table table-bordered" id="blogtable">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Title</th>
        <th>Language</th>
        <!-- <th>Domain</th> -->
        <th>Image</th>
        <th>Status</th>
        <th> Status Update</th>
        @canany(['blog-edit', 'blog-delete'])
        <th width="280px">Action</th>
        @endcanany
    </tr>
    @foreach ($blogs as $key => $blog)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ substr($blog->name, 0, 10) }}...</td>
        <td>{{ $blog->blogcategories->title }}</td>
        <td>{{ $blog->languages?->language_name ?? 'No language' }}</td>
        <!-- <td>{{ $blog->domains?->domain_name ?? 'No domain' }}</td> -->
        <td>
            @if ($blog->image)
            <img src="{{ asset($blog->image) }}" class="card-img-top" height="50px" style="width:100px;">
            @else
            No image
            @endif
        </td>

        <td>
            <select id="select" class="form-control status-dropdown" data-id="{{ $blog->id }}" style="width: auto;">
                @if($blog->approvedstatus)
                @foreach($designation->take($blog->approvedstatus->designation_id) as $item)
                <option id="option" value="{{ $item->id }}"
                    data-deginationid="{{ $blog->approvedstatus->designation_id }}" data-userid="{{ $item->id }} "
                    <?php  if ($blog->approvedstatus->designation_id == $item->id ){ echo 'selected'; }else{ echo 'disabled'; } ?>>

                    {{ $item->designation_name }}
                </option>
                @endforeach
                @else
                <option>No designation</option>
                @endif
            </select>
        </td>

        <th style="display: flex; border: none;">
            <form action="{{ route('approve_book', $blog->id) }}" method="POST" style="display:inline"
                data-userid="{{auth()->user()->designation_id }}">
                @csrf
                @if($blog->approvedstatus && $blog->id && $blog->approvedstatus->designation_id == $item->id )
                <button type="submit" class="btn btn-success btn-sm px-3" data-deginationid="{{ $item->id }}"
                    data-test="{{$blog->id}}"
                    <?php if(auth()->user()->designation_id > $item->id){ echo ''; }else{echo 'disabled'; } ?>>Approve</button>
                @else
                <button type="submit" class="btn btn-success btn-sm px-3">Approve</button>
                @endif

            </form>


            <form action="{{ route('rejected_book', $blog->id) }}" method="POST" style="display:inline">
                @csrf
                @if($blog->approvedstatus && $blog->id && $blog->approvedstatus->designation_id == $item->id )
                <button type="submit" class="btn btn-danger btn-sm px-3" data-deginationid="{{ $item->id }}"
                    data-test="{{$blog->id}}"
                    <?php if(auth()->user()->designation_id < $item->id){ echo 'disabled'; }else{ echo ''; }  ?>>Reject</button>
                @else
                <button type="submit" class="btn btn-danger btn-sm px-3">Reject</button>
                @endif
                <!-- <input type="hidden" name="status" value="rejected">
    <button type="submit" class="btn btn-primary btn-sm">Reject</button> -->
            </form>

        </th>

        <td>
            <!-- <a class="btn btn-info btn-sm" href="{{ route('blog.show', $blog->id) }}"><i class="fa-solid fa-list"></i> Show</a> -->
             @can('blog-edit')
            <a class="btn btn-primary btn-sm" href="{{ route('blog.edit', $blog->id) }}"><i
                    class="fa-solid fa-pen-to-square"></i> </a>
                    @endcan
                    @can('blog-delete')
            <form method="POST" action="{{ route('blog.destroy', $blog->id) }}" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> </button>
            </form>
            @endcan
        </td>

    </tr>
    @endforeach
</table>

{!! $blogs->links('pagination::bootstrap-5') !!}



@endsection