@extends('layouts.admin.dashboard')
@section('title', 'Alat')
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Alat</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">List Alat</h6>
    </nav>
@endsection
@php

    use Carbon\Carbon;

    function isAlatOff($updated_at)
    {
        $timestamp = Carbon::parse($updated_at)
            ->setTimeZone('Asia/Jakarta')
            ->subHours(7);
        $now = Carbon::now()
            ->setTimezone('Asia/Jakarta')
            ->subSeconds(20);

        if ($timestamp->lt($now)) {
            return true;
        } else {
            return false;
        }
    }

@endphp
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h3>List Alat</h3>
                        <a href="{{ route('admin.alat.create') }}" class="btn btn-primary">Tambah</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>ID</th>
                                        <th>Lokasi Alat</th>
                                        <td>Status</td>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alats as $alat)
                                        <tr>
                                            <td>{{ $alat->id }}</td>
                                            <td>{{ $alat->lokasi }}</td>
                                            <td>
                                                @if (isAlatOff($alat->updated_at))
                                                    <div class="badge bg-danger text-white">Off</div>
                                                @else
                                                    <div class="badge bg-success text-white">On</div>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center gap-5">
                                                    <a href="{{ route('admin.alat.view', $alat->id) }}"
                                                        class="text-primary"><i class="fa-regular fa-eye"></i></a>
                                                    <a href="{{ route('admin.alat.edit', $alat->id) }}"
                                                        class="text-success"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <a href="{{ route('admin.alat.delete', $alat->id) }}"
                                                        class="text-danger"><i class="fa-regular fa-trash-can"></i></a>
                                                </div>
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
    </div>
@endsection
