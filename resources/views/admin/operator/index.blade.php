@extends('layouts.admin.dashboard')
@section('title', 'Operator')
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Operator</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">List Operator</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h3>List Operator</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addOperator">Daftarkan Operator</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Email Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($operators as $operator)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $operator->firstname . ' ' . $operator->lastname }}</td>
                                            <td>{{ $operator->email }}</td>
                                            <td class="text-center">
                                                @if ($operator->email_verified_at != null)
                                                    <span class="badge text-bg-info text-white">verified</span>
                                                @else
                                                    <span class="badge text-bg-warning text-white">unverified</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center gap-5">
                                                    <a href="{{ route('admin.operator.view', $operator->id) }}"
                                                        class="text-primary"><i class="fa-regular fa-eye"></i></a>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#addCategory{{ $operator->id }}" class="text-danger"
                                                        style="cursor: pointer"><i class="fa-regular fa-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Modal  to delete operator -->
                                        <div class="modal fade" id="addCategory{{ $operator->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <span class=" fs-5" id="staticBackdropLabel">Anda yakin
                                                            untuk menghapus
                                                            <b>{{ $operator->firstname . ' ' . $operator->lastname }}</b>
                                                            dari operator?
                                                        </span>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <a href="{{ route('admin.operator.delete', $operator->id) }}"
                                                            class="btn btn-danger">Yakin</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-5">
                                {{ $operators->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal to add operator -->
    <div class="modal fade" id="addOperator" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.operator.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="firstname" class="form-label">Firstname</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="form-label">Lastname</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
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
@endsection
