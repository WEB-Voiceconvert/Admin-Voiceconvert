@extends('layouts.admin.dashboard')
@section('title', 'Event')
@push('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('breadcumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Event</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">Update Kategori Event</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-3">
                        <form action="{{ route('admin.event.category.update', $category->id) }}" method="POST">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="namaKategori" class="form-label">Nama Kategori</label>
                                <input type="text" id="namaKategori" name="nama_kategori" class="form-control"
                                    value="{{ $category->nama_kategori }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
