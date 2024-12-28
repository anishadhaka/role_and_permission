@extends('layouts.app')

@section('content')
{{$formattedDate}}
<div class="container">
<!-- <div>
    <a href="{{ route('blogsite') }}">
        <i class="fas fa-eye" style="font-size:26px"></i>
    </a>
    Front
</div> -->

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                 
            
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
