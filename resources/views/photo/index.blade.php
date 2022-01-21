@extends('layouts.app')
@section('title') My Photo @endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        My Photo
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            @forelse(auth()->user()->photos as $photo)
                                <div class="position-relative">
                                    <form action="{{ route('photo.destroy', $photo->id) }}"
                                          class="position-absolute bottom-0 start-0" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm" title="delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <a class="venobox" href="{{ asset('storage/photo/'.$photo->name) }}">
                                        <img src="{{ asset('storage/thumbnail/'.$photo->name) }}" class="me-2 border border-2 border-dark" height="100" width="100" alt="image alt"/>
                                    </a>
                                </div>
                            @empty
                                <p class="text-muted">No Photo</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
