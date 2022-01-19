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
                        <form action="{{ route('category.store') }}" class="mb-3" method="post">
                            @csrf
                            <div class="row align-items-end">
                                <div class="col-6 col-lg-3">
                                    <label class="form-label" for="title">Category Title</label>
                                    <input type="text" name="title"
                                           class="form-control @error('title') is-invalid @enderror @if(session('status')) is-valid @endif"
                                           id="title" value="{{ old('title') }}">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <button class="btn btn-primary">Add Category</button>
                                </div>
                            </div>
                            @if(session('status'))
                                <small class="text-success fw-bolder">{{ session('status') }}</small>
                            @endif
                            @error('title')
                            <small class="text-danger mb-0 fw-bolder">{{ $message }}</small>
                            @enderror
                        </form>

                        <table class="table align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Owner</th>
                                <th>Controls</th>
                                <th>Created_at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->title }}</td>
                                    <td>{{ $category->user->name ?? "unknown" }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('category.edit', $category->id) }}"
                                               class="btn btn-outline-primary btn-sm" title="edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button form="categoryDeleteForm{{ $category->id }}"
                                                    class="btn btn-outline-primary btn-sm" title="delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <form action="{{ route('category.destroy', $category->id) }}"
                                                  id="categoryDeleteForm{{ $category->id }}" class="d-inline-block"
                                                  method="post">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="small">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $category->created_at->format('d M Y') }}
                                        </span><br>
                                        <span class="small">
                                            <i class="fas fa-clock"></i>
                                            {{ $category->created_at->format('H : i a') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5">There is no category 😥</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <div class="text-center">
                            <a href="{{ route('category.index') }}" class="btn btn-primary">All Category List</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
