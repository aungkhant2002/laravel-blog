@extends('layouts.app')
@section('title') Post List @endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Post List
                    </div>
                    <div class="card-body">
                        <table class="table align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Photo</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Owner</th>
                                <th>Controls</th>
                                <th>Created_at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>
                                        @forelse($post->photos as $photo)
                                            <a class="venobox" data-gall="img{{ $post->id }}" href="{{ asset('storage/photo/'.$photo->name) }}">
                                                <img src="{{ asset('storage/thumbnail/'.$photo->name) }}" height="30" alt="image alt"/>
                                            </a>
                                        @empty
                                            <p class="text-muted">No Photo</p>
                                        @endforelse
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::words($post->description, 20) }}</td>
                                    <td>{{ $post->category->title }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('post.show', $post->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button form="postDeleteForm{{ $post->id }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                        <form action="{{ route('post.destroy', $post->id) }}" method="post" id="postDeleteForm{{ $post->id }}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
                                    <td class="text-nowrap">
                                        <span class="small">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $post->created_at->format('d M Y') }}
                                        </span><br>
                                        <span class="small">
                                            <i class="fas fa-clock"></i>
                                            {{ $post->created_at->format('H : i a') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="8">There is no post 😥</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
