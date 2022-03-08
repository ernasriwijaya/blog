<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <title>{{ __('Spatie Media') }} </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
  
<body>
    <div class="container">
        <h1>{{ __('Spatie Media') }}</h1>
        
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Body') }}</th>
                    <th width="30%">Image</th>
                    <th>Slug</th>
                    <th>Function</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $key=>$post)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->body }}</td>
                    <td><img src="{{$post->getFirstMediaUrl('images', 'thumb')}}" / width="120px"></td>
                    <td>{{ $post->slug }}</td>
                    <td>
                    <div class="d-flex p-2 bd-highlight mb-1">
                    <a href="{{ route('posts.create') }}" class="btn btn-dark">Add</a>
                    </div>
                    <div class="d-flex p-2 bd-highlight mb-1">
                    <a href="{{ route('posts.create') }}" class="btn btn-success">Edit</a>
                    </div>
                    <div class="d-flex p-2 bd-highlight mb-1">
                    <a href="{{ route('posts.create') }}" class="btn btn-danger">Delete</a>
                    </div>
                    
                    </td>
                </tr>
                @endforeach

             
               
  
</html>