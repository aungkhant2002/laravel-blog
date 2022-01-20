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
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('post.create') }}" class="btn btn-primary">Create Post</a>
                            <form method="get">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search Something" name="search" value="{{ request()->search }}">
                                    <button class="btn btn-primary" type="submit" id="button-addon2">
                                        <i class="fas fa-search fa-fw"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <table class="table align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Photo</th>
                                <th>Is_publish</th>
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
                                    <td>{{ \Illuminate\Support\Str::words($post->title, 5) }}</td>
                                    <td>
                                        @forelse($post->photos as $photo)
                                            <a class="venobox" data-gall="img{{ $post->id }}" href="{{ asset('storage/photo/'.$photo->name) }}">
                                                <img src="{{ asset('storage/thumbnail/'.$photo->name) }}" height="30" alt="image alt"/>
                                            </a>
                                        @empty
                                            <p class="text-muted">No Photo</p>
                                        @endforelse
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $post->is_publish == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">{{ $post->is_publish ? 'Publish' : 'Unpublish' }}</label>
                                        </div>
                                    </td>
                                    <td>{{ $post->category->title ?? "Unknown Category" }}</td>
                                    <td>{{ $post->user->name ?? "Unknown User" }}</td>
                                    <td>
                                        <div class="btn-group">

                                            <a href="{{ route('post.show', $post->id) }}" class="btn btn-outline-primary btn-sm" title="detail">
                                                <i class="fas fa-info-circle"></i>
                                            </a>

                                            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-outline-primary btn-sm" title="edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            <button form="postDeleteForm{{ $post->id }}" class="btn btn-outline-primary btn-sm" title="delete">
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
                        <div class="d-flex justify-content-between align-items-center">
                            {{ $posts->appends(request()->all())->links() }}
                            <p class="h4 text-primary fw-bolder">Total : {{ $posts->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
