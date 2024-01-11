@extends('layouts.operator.dashboard')
@section('title', 'Berita')
@section('breadcumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Berita</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">View Berita</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $berita->judul }}</h2>
                    </div>
                    <div class="card-body ">
                        <div>
                            <img src="{{ asset('assets/images/' . $berita->gambar) }}" alt="image"
                                style="max-width: 100%; width: 500px">
                        </div>
                        <div> {!! html_entity_decode($berita->deskripsi) !!}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h3>List Voice</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addVoice">Tambah</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table w-100 mb-0">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Voice</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($berita->voices as $voice)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $voice->filename }}</td>
                                            <td><audio controls class="w-100">
                                                    <source src="{{ asset('assets/voices/' . $voice->filename) }}">
                                                </audio>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('operator.berita.voice.delete', $voice->id) }}"
                                                    class="text-danger"><i class="fa-regular fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal to add voice -->
        <div class="modal fade" id="addVoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('operator.berita.voice.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Voice</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="namaVoice" class="form-label">Nama Voice</label>
                                <input type="text" class="form-control" id="namaVoice" name="nama_voice" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="fileVoice" class="form-label">File Voice</label>
                                <input type="file" accept="audio/*" class="form-control" id="fileVoice" name="file_voice"
                                    required>
                            </div>
                            <input type="hidden" name="id_berita" value="{{ $berita->id }}">
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
