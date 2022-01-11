@extends('layouts.app')
@section('title') {{ $post->title }} @endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0">{{ $post->title }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="text-primary fw-bolder me-3">
                                <i class="fas fa-layer-group"></i>
                                {{ $post->category->title }}
                            </span>
                            <span class="text-primary fw-bolder me-3">
                                <i class="fas fa-user"></i>
                                {{ $post->user->name }}
                            </span>
                            <span class="text-primary fw-bolder me-3">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $post->created_at->format('d M Y') }}
                            </span>
                            <span class="text-primary fw-bolder me-3">
                                <i class="fas fa-clock"></i>
                                {{ $post->created_at->format('H : i a') }}
                            </span>
                        </div>
                        <p class="text-black-50">{{ $post->description }}</p>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('post.index') }}" class="btn btn-secondary">All Posts</a>
                            <span class="text-primary fw-bolder me-3">
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
