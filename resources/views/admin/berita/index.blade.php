@extends('layouts.admin.dashboard')
@section('title', 'Berita')
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Berita</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">List Berita</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h3>List Berita</h3>
                        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">Tambah</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($beritas as $berita)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $berita->judul }}</td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center gap-5">
                                                    <a href="{{ route('admin.berita.view', $berita->id) }}"
                                                        class="text-primary"><i class="fa-regular fa-eye"></i></a>
                                                    <a href="{{ route('admin.berita.edit', $berita->id) }}"
                                                        class="text-success"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <a href="{{ route('admin.berita.delete', $berita->id) }}"
                                                        class="text-danger"><i class="fa-regular fa-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-3">
                                {!! $beritas->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
