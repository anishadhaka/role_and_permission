@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>News Management</h2>
        </div>
      
 
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('news.create') }}"><i class="fa fa-plus"></i> Create New News</a>
        </div>
    </div>
    
</div> 
<div class="language-picker mb-1">
    <form action="{{ route('news.index') }}" method="GET" class="language-picker__form" style="display:flex;margin-left:700px;">
        <label for="language-picker-select" style="font-weight:bold;margin-top:7px; padding:2px;">Language</label>
        <select name="language" class="form-control" style="width:120px;height:40px;" onchange="this.form.submit()">
            <option value="">All</option> 
            @foreach ($languages as $key => $language)
                <option value="{{ $language }}" >
                    {{ $language }}
                </option>
            @endforeach
        </select>
    </form>
</div>

       

@session('success')
    <div class="alert alert-success" role="alert"> 
        {{ $value }}
    </div>
@endsession

<table class="table table-bordered">
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
   @foreach ($newss as $key => $news)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $news->name }}</td>
        <td>{{ $news->categories->title }}</td>
        <td>{{$news->languages?->language_name ?? 'no language'}}</td>
        <td>{{$news->domains?->domain_name ?? 'no domain'}} </td>
        <td>
    <select class="form-control status-dropdown" data-id="{{ $news->id }}">
        @foreach($status as $id => $status_name)
            <option value="{{ $id }}" {{ $news->status_id == $id ? 'selected' : '' }}>
                {{ $status_name }}
            </option>
        @endforeach
    </select>
</td>
        <td>
           @if ($news->image)
           <img src="{{ asset('images/' . $news->image) }}" class="card-img-top"  height="40px">
           @else
               No image
           @endif
        </td>

       
        <td>
             <a class="btn btn-info btn-sm" href="{{ route('news.show',$news->id) }}"><i class="fa-solid fa-list"></i> Show</a>
             <a class="btn btn-primary btn-sm" href="{{ route('news.edit',$news->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
              <form method="POST" action="{{ route('news.destroy', $news->id) }}" style="display:inline">
                  @csrf
                  @method('DELETE')

                  <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
              </form>
        </td>
    </tr>
 @endforeach
</table>

{!! $newss->links('pagination::bootstrap-5') !!}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Triggered when a status dropdown is changed
        $('.status-dropdown').change(function() {
            var status_id = $(this).val(); // Get the selected status id
            var news_id = $(this).data('id'); // Get the news id

            // Send the AJAX request
            $.ajax({
                url: '{{ route('news.status.update') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    news_id: news_id,
                    status_id: status_id
                },
                success: function(response) {
                    alert(response.success); // Show success message
                },
                error: function(response) {
                    alert('There was an error updating the status.');
                }
            });
        });
    });
</script>



@endsection
