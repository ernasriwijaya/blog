@extends('layouts.app')

@section('content')
<div class="container">
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
                   
                    <tr>
                    <div class="d-flex p-2 bd-highlight mb-5">
                    <a href="{{ route('posts.index') }}" class="btn btn-success">Spatie Media</a>
                    </div>   
                    </tr>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
