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
        <h6 class="font-weight-bolder mb-0">View Operator</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h3>{{ $operator->firstname . ' ' . $operator->lastname }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless" style="max-width: 500px">
                                <tbody>
                                    <tr>
                                        <td>Firstname</td>
                                        <td>:</td>
                                        <td>{{ $operator->firstname }}</td>
                                    </tr>
                                    <tr>
                                        <td>Lastname</td>
                                        <td>:</td>
                                        <td>{{ $operator->lastname }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{ $operator->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>No Telepon</td>
                                        <td>:</td>
                                        <td>{{ $operator->telepon }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td>{{ $operator->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status email</td>
                                        <td>:</td>
                                        <td class="d-flex align-items-start">
                                            @if ($operator->email_verified_at != null)
                                                <span class="badge text-bg-info text-white">verified</span>
                                            @else
                                                <span class="badge text-bg-warning text-white">unverified</span>
                                                <form action="{{ route('admin.operator.resend') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="email" value="{{ $operator->email }}">
                                                    <button type="submit" class="btn btn-link btn-sm text-info">Kirim
                                                        ulang link
                                                        verifikasi</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @if (\Session::has('resent'))
                                                <div class="alert alert-success">
                                                    <ul>
                                                        <li>{!! \Session::get('resent') !!}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                            @if (\Session::has('error'))
                                                <div class="alert alert-success">
                                                    <ul>
                                                        <li>{!! \Session::get('error') !!}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
