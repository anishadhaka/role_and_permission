@extends('layouts.app')

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
            <a class="btn btn-success mb-2" href="{{ route('blog.create') }}"><i class="fa fa-plus"></i> Create New Blog</a>
            <div class="language-picker mb-1">
                <form action="{{ route('blog.index') }}" method="GET" class="language-picker__form" style="display:flex;margin-left:700px;margin-top:-50px;">
                    <label for="language-picker-select" style="font-weight:bold;margin-top:7px; padding:2px;">Language</label>
                    <select name="language" class="form-control" style="width:120px;height:40px;" onchange="this.form.submit()">
                        <option value="">All</option> <!-- Option for showing all blogs -->
                        @foreach ($languages as $language)
                            <option value="{{ $language }}">
                                {{ $language }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

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
        <th>Domain</th>
        <th>Status</th>
        <th>Image</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($blogs as $key => $blog)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $blog->name }}</td>
            <td>{{ $blog->blogcategories->title }}</td>
            <td>{{ $blog->languages?->language_name ?? 'No language' }}</td>
            <td>{{ $blog->domains?->domain_name ?? 'No domain' }}</td>
            <td>
                <select id="select" class="form-control status-dropdown" data-id="{{ $blog->id }}">
                    @foreach($status as $id => $status_name)
                        <option id="option" value="{{ $id }}" {{ $blog->status_id == $id ? 'selected' : '' }}>
                            {{ $status_name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                @if ($blog->image)
                    <img src="{{ asset('images/' . $blog->image) }}" class="card-img-top" height="50px" style="width:100px;">
                @else
                    No image
                @endif
            </td>
            <td>
                <a class="btn btn-info btn-sm" href="{{ route('blog.show', $blog->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                <a class="btn btn-primary btn-sm" href="{{ route('blog.edit', $blog->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                <form method="POST" action="{{ route('blog.destroy', $blog->id) }}" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

{!! $blogs->links('pagination::bootstrap-5') !!}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-dropdown').change(function() {
            var status_id = $(this).val(); 
            var blog_id = $(this).data('id'); 

            $.ajax({
                url: '{{ route('blogs.status.update') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    blog_id: blog_id,
                    status_id: status_id
                },
                success: function(response) {
                    toastr.success(response.success, 'Success', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000
                    });
                },
                error: function(response) {
                    toastr.error('There was an error updating the status.', 'Error', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000
                    });
                }
            });
        });
    });
</script>


@endsection
