@extends('layouts.admin.dashboard')
@section('title', 'Paket')
@push('head')
    <style>
        .active .page-link {
            color: white
        }
    </style>
@endpush
@section('breadcumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Paket</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">List Paket</h6>
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
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h3>List Paket</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addPaket">Tambah</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Jenis Paket</th>
                                        <th>Nominal</th>
                                        <th>Masa Berlaku</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pakets as $paket)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $paket->jenis_paket }}</td>
                                            <td>{{ rupiah($paket->nominal) }}</td>
                                            <td>{{ $paket->masa_berlaku }} hari</td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center gap-5">
                                                    <a href="{{ route('admin.paket.edit', $paket->id) }}"
                                                        class="text-success"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <a href="{{ route('admin.paket.delete', $paket->id) }}"
                                                        class="text-danger"><i class="fa-regular fa-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-3">
                                {!! $pakets->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal to add paket -->
            <div class="modal fade" id="addPaket" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('admin.paket.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kategori</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mt-3">
                                    <label for="jenis" class="form-label">Jenis Paket</label>
                                    <input type="text" class="form-control" id="jenis" name="jenis" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="nominal" class="form-label">Nominal</label>
                                    <input type="number" class="form-control" id="nominal" name="nominal" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="masa" class="form-label">Masa Berlaku</label>
                                    <div class="input-group mb-3 d-flex">
                                        <input type="number" id="masa" name="masa" class="form-control"
                                            aria-label="Masa berlaku" aria-describedby="masa-addon" required>
                                        <span class="input-group-text" style="visibility: hidden"></span>
                                        <span class="input-group-text" id="masa-addon">Hari</span>
                                    </div>
                                </div>
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
    </div>
@endsection
