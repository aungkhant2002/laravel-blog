@extends('layouts.app')
@section('title') Category List @endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Category List
                    </div>
                    <div class="card-body">
                        @if(session('status'))
                            <p class="alert alert-success mb-0">{{ session('status') }}</p>
                        @endif
                        <table class="table align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Owner</th>
                                <th>Photo</th>
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
                                    <td>@forelse($category->photos as $photo)
                                            <a class="venobox" data-gall="img{{ $category->id }}" href="{{ asset('storage/photo/'.$photo->name) }}">
                                                <img src="{{ asset('storage/thumbnail/'.$photo->name) }}" class="rounded-circle border border-2 border-success" style="margin-left: -20px" height="40" width="40" alt="image alt"/>
                                            </a>
                                        @empty
                                            <p class="text-muted">No Photo</p>
                                        @endforelse</td>
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
                        <div class="d-flex justify-content-between align-items-center">
                            {{ $categories->links() }}
                            <p class="fw-bolder mb-0 h4">Total : {{ $categories->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
