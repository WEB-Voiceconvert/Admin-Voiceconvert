@extends('layouts.admin.dashboard')
@section('title', 'Paket')

@section('breadcumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Paket</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">Update Paket</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-3">
                        <form action="{{ route('admin.paket.update', $paket->id) }}" method="POST">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="jenis" class="form-label">Jenis Paket</label>
                                <input type="text" class="form-control" id="jenis" name="jenis"
                                    value="{{ $paket->jenis_paket }}" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="nominal" class="form-label">Nominal</label>
                                <input type="number" class="form-control" id="nominal" name="nominal"
                                    value="{{ $paket->nominal }}" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="masa" class="form-label">Masa Berlaku</label>
                                <div class="input-group mb-3 d-flex">
                                    <input type="number" id="masa" name="masa" class="form-control"
                                        aria-label="Masa berlaku" aria-describedby="masa-addon"
                                        value="{{ $paket->masa_berlaku }}" required>
                                    <span class="input-group-text" style="visibility: hidden"></span>
                                    <span class="input-group-text" id="masa-addon">Hari</span>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
