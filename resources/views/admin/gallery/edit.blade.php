@extends('layouts.admin.dashboard')
@section('title', 'Gallery')
@push('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('breadcumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Gallery</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">Update Gallery</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-3">
                        <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="judul" class="form-label">Nama Gallery</label>
                                <input type="text" id="judul" name="judul" class="form-control"
                                    value="{{ $gallery->judul }}">
                            </div>
                            <div class="form-group">
                                <label for="summernote" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" id="summernote" cols="30" rows="10">{{ $gallery->deskripsi }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h6>Gambar Gallery</h6>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addImage">Tambah</button>
                        </div>
                        <div class="row align-items-center">
                            @foreach ($gallery->images as $image)
                                <div class="col-md-3 col-lg-2 my-3 mx-3 border rounded">
                                    <div class="d-flex flex-column align-items-center">
                                        <img src="/{{ $image->filename }}" alt="{{ $image->filename }}" width="100%" />
                                        <a href="{{ route('admin.gallery.image.delete', $image->id) }}" class="mt-3"><span
                                                class="fa fa-trash text-danger"></span></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal to add image -->
        <div class="modal fade" id="addImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.gallery.image.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Gambar</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="file" accept="image/*" class="form-control" id="image" name="gambar"
                                    required>
                            </div>
                            <input type="hidden" name="gallery_id" value="{{ $gallery->id }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('#summernote').summernote({
            // placeholder: 'Hello stand alone ui',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', ]],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
@endpush
