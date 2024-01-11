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
        <h6 class="font-weight-bolder mb-0">View Member</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h3>{{ $member->firstname . ' ' . $member->lastname }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless" style="max-width: 500px">
                                <tbody>
                                    <tr>
                                        <td>Firstname</td>
                                        <td>:</td>
                                        <td>{{ $member->firstname }}</td>
                                    </tr>
                                    <tr>
                                        <td>Lastname</td>
                                        <td>:</td>
                                        <td>{{ $member->lastname }}</td>
                                    </tr>
                                    <tr>
                                        <td>Paket</td>
                                        <td>:</td>
                                        <td>{{ $member->paket->jenis_paket ?? '-' }} <button type="button"
                                                class="badge text-bg-success text-white border border-0 ms-3"
                                                data-bs-toggle="modal" data-bs-target="#changePaket">Ubah</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Paket berakhir pada</td>
                                        <td>:</td>
                                        <td>{{ $member->paket_expired_at ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{ $member->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>No Telepon</td>
                                        <td>:</td>
                                        <td>{{ $member->telepon }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td>{{ $member->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status email</td>
                                        <td>:</td>
                                        <td class="d-flex align-items-start">
                                            @if ($member->email_verified_at != null)
                                                <span class="badge text-bg-info text-white">verified</span>
                                            @else
                                                <span class="badge text-bg-warning text-white">unverified</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Modal to change paket -->
                    <div class="modal fade" id="changePaket" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('admin.member.update', $member->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kategori</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group mt-3">
                                            <label for="formPaket" class="form-label">Jenis Paket</label>
                                            <select name="form_paket" id="formPaket" class="form-select"
                                                aria-placeholder="Select Paket" required>
                                                {{-- <option selected>Select Paket</option> --}}
                                                @foreach ($pakets as $paket)
                                                    <option value="{{ $loop->iteration }}">{{ $paket->jenis_paket }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="expiredPaketPlain" class="form-label">Paket Berakhir Pada</label>
                                            <input type="hidden" name="expired_paket" id="expiredPaket">
                                            <input type="text" id="expiredPaketPlain" class="form-control-plaintext"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var pakets = '{{ $pakets }}';
        pakets = pakets.replaceAll('&quot;', '\"');
        pakets = pakets.replaceAll('&quot;:', '\"');
        const paket = JSON.parse(pakets);

        $(document).ready(function() {
            $('#formPaket').on('change', function() {
                var expired = new Date(Date.now() + (paket[this.value - 1].masa_berlaku * 24 * 60 * 60 *
                    1000));
                $('#expiredPaketPlain').val(expired.toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric',
                }));
                $('#expiredPaket').val(paket[this.value - 1].masa_berlaku);
            });
        });
    </script>
@endpush
