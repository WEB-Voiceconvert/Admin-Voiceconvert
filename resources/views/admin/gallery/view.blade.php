@extends('layouts.admin.dashboard')
@section('title', 'Gallery')
@section('breadcumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Gallery</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">View Gallery</h6>
    </nav>
@endsection

@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $gallery->judul }}</h2>
                    </div>
                    <div class="card-body ">
                        <div id="carouselExampleIndicators" class="carousel slide" style="width: 500px; max-width: 100%;">
                            <div class="carousel-inner">
                                @foreach ($gallery->images as $image)
                                    <div class="carousel-item @if ($loop->index == 0) active @endif">
                                        <img width="500px" style="max-width: 100%" src="{{ url($image->filename) }}"
                                            alt="image">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <div> {!! html_entity_decode($gallery->deskripsi) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
