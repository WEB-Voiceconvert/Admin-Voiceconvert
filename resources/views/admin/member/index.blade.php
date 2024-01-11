@extends('layouts.admin.dashboard')
@section('title', 'Member')
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Member</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">List Member</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h3>List Member</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Fullname</th>
                                        <th>Paket Aktif</th>
                                        <th>Email</th>
                                        <th>Email Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $member->firstname . ' ' . $member->lastname }}</td>
                                            <td>{{ $member->paket->jenis_paket ?? 'Tidak terdaftar' }}</td>
                                            <td>{{ $member->email }}</td>
                                            <td class="text-center">
                                                @if ($member->email_verified_at != null)
                                                    <span class="badge text-bg-info text-white">verified</span>
                                                @else
                                                    <span class="badge text-bg-warning text-white">unverified</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center gap-5">
                                                    <a href="{{ route('admin.member.view', $member->id) }}"
                                                        class="text-primary"><i class="fa-regular fa-eye"></i></a>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#addCategory{{ $member->id }}" class="text-danger"
                                                        style="cursor: pointer"><i class="fa-regular fa-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Modal  to delete member -->
                                        <div class="modal fade" id="addCategory{{ $member->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <span class=" fs-5" id="staticBackdropLabel">Anda yakin
                                                            untuk menghapus
                                                            <b>{{ $member->firstname . ' ' . $member->lastname }}</b>
                                                            dari member?
                                                        </span>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <a href="{{ route('admin.member.delete', $member->id) }}"
                                                            class="btn btn-danger">Yakin</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-5">
                                {{ $members->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
