@extends('layouts.app')
@section('title') Create Post @endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        Create Post
                    </div>
                    <div class="card-body">

                        @if(session('status'))
                            <p class="alert alert-success">{{ session('status') }}</p>
                        @endif
                        <form action="{{ route('post.store') }}" method="post" class="mb-3"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Post Title</label>
                                <input type="text" name="title" id="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}">
                                @error('title')
                                <small class="text-danger fw-bolder">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Select Category</label>
                                <select name="category" id="category"
                                        class="form-select @error('category') is-invalid @enderror">
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option
                                            value="{{ $category->id }}" {{ $category->id == old('category') ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <small class="text-danger fw-bolder">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Select Tag</label>
                                <br>
                                <div class="">
                                    @foreach(\App\Models\Tag::all() as $tag)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" value="{{ $tag->id }}"
                                                   name="tags[]"
                                                   id="tag{{ $tag->id }}" multiple {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tag{{ $tag->id }}">
                                                {{ $tag->title }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('tags')
                                <small class="text-danger fw-bolder">{{ $message }}</small>
                                @enderror
                                @error('tags.*')
                                <small class="text-danger fw-bolder">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="photo" class="form-label">Upload Photo</label>
                                <input type="file" name="photo[]" id="photo"
                                       class="form-control @error('photo') is-invalid @enderror" multiple>
                                @error('photo')
                                <small class="text-danger fw-bolder">{{ $message }}</small>
                                @enderror
                                @error('photo.*')
                                <small class="text-danger fw-bolder">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" rows="4"
                                          class="form-control">{{ old('description') }}</textarea>
                                @error('description')
                                <small class="text-danger fw-bolder">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
                                           required>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Confirm</label>
                                </div>
                                <button class="btn btn-primary">Create Post</button>
                            </div>

                        </form>

                        {{-- displaying validation errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
