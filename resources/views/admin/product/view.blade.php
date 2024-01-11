@extends('layouts.admin.dashboard')
@section('title', 'Product')
@section('breadcumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Product</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">View Product</h6>
    </nav>
@endsection
@php
    function rupiah($angka)
    {
        $hasil_rupiah = 'Rp ' . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }
@endphp
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $product->judul }}</h2>
                    </div>
                    <div class="card-body ">
                        <div id="carouselExampleIndicators" class="carousel slide" style="width: 300px">
                            <div class="carousel-inner">
                                @foreach ($product->images as $image)
                                    <div class="carousel-item @if ($loop->index == 0) active @endif">
                                        <img width="300px" src="{{ url($image->name) }}" alt="image">
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
                        <h4>{{ rupiah($product->harga) }}</h4>
                        <div> {!! html_entity_decode($product->deskripsi) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
