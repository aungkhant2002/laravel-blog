@extends('layouts.app')
@section('title') Edit Post @endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        Edit Post
                    </div>
                    <div class="card-body">
                        <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="title" class="form-label">Post Title</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}">
                                @error('title')
                                <small class="text-danger fw-bolder">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Select Category</label>
                                <select name="category" id="category" class="form-select @error('category') is-invalid @enderror">
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == old('category',$post->category_id) ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <small class="text-danger fw-bolder">{{ $message }}</small>
                                @enderror
                            </div>
                            {{--                            <div class="mb-3">--}}
                            {{--                                <label for="photo" class="form-label">Upload Photo</label>--}}
                            {{--                                <input type="file" name="photo" id="photo" class="form-control">--}}
                            {{--                            </div>--}}
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $post->description) }}</textarea>
                                @error('description')
                                <small class="text-danger fw-bolder">{{ $message }}</small>
                                @enderror
                            </div>
                            <button class="btn btn-primary">Update Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
