@extends('layouts.app')
@section('title') Create Category @endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Create Category
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category.store') }}" method="post">
                            @csrf
                            <div class="row align-items-end">
                                <div class="col-6 col-lg-3">
                                    <label class="form-label" for="title">Category Title</label>
                                    <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <button class="btn btn-primary">Add Category</button>
                                </div>
                            </div>
                            @error('title')
                            <small class="text-danger mb-0 fw-bolder">{{ $message }}</small>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
