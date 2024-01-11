@extends('layouts.operator.dashboard')
@section('title', 'Event')
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Event</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">List Event</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h3>Kategori</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory">
                            Tambah</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table w-100 mb-0">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->nama_kategori }}</td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center gap-5">
                                                    <a href="{{ route('operator.event.category.edit', $category->id) }}"
                                                        class="text-success"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <a href="{{ route('operator.event.category.delete', $category->id) }}"
                                                        class="text-danger"><i class="fa-regular fa-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            {!! $categories->links() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal to add category -->
            <div class="modal fade" id="addCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('operator.event.category.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kategori</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="namaKategori" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control" id="namaKategori" name="nama_kategori"
                                        required>
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
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h3>List Event</h3>
                        <a href="{{ route('operator.event.create') }}" class="btn btn-primary">Tambah</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table w-100 mb-0">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Nama Event</th>
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                        <th>Tanggal Event</th>
                                        <th class="text-center">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($events as $event)
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $event->nama_event }}</td>
                                            <td>{{ $event->category->nama_kategori }}</td>
                                            <td>{{ $event->lokasi }}</td>
                                            <td>{{ $event->tgl_event }}</td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center gap-5">
                                                    <a href="{{ route('operator.event.view', $event->id) }}"
                                                        class="text-primary"><i class="fa-regular fa-eye"></i></a>
                                                    <a href="{{ route('operator.event.edit', $event->id) }}"
                                                        class="text-success"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <a href="{{ route('operator.event.delete', $event->id) }}"
                                                        class="text-danger"><i class="fa-regular fa-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            {!! $events->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
