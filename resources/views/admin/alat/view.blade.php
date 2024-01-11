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
        {{-- <h6 class="font-weight-bolder mb-0">List Alat</h6> --}}
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless" style="max-width: 500px">
                                <tbody>
                                    <tr>
                                        <td>UUID</td>
                                        <td>:</td>
                                        <td>{{ $alat->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Lokasi Alat</td>
                                        <td>:</td>
                                        <td>{{ $alat->lokasi }}</td>
                                    </tr>
                                    <tr>
                                        <td>Maps</td>
                                        <td>:</td>
                                        <td>{{ $alat->latitude }}, {{ $alat->longitude }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div id="map" style = "width: 900px; height: 580px; max-width: 100%;">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <form action="{{ route('admin.alat.updateApi') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $alat->id }}">
                                                <button class="btn btn-success" type="submit">Generate New API KEY</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @if (\Session::has('key'))
                            <div class="alert alert-light d-inline mb-3">A new API KEY for {{ $alat->lokasi }} has been
                                successfully created. here is the api key : <strong>{!! \Session::get('key') !!}</strong></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        var map = L.map('map', {
            center: ['{{ $alat->latitude }}', '{{ $alat->longitude }}'],
            zoom: 10,
            scrollWheelZoom: false
        });
        map.addLayer(layer);

        var customAlatMarker = L.icon({
            iconUrl: "{{ url('assets/images/map_blue.png') }}",
            iconSize: [40, 40],
        });

        var markerLayer = L.layerGroup().addTo(map);

        function addMarker() {
            markerLayer.clearLayers();
            marker = new L.marker(['{{ $alat->latitude }}', '{{ $alat->longitude }}'], {
                draggable: 'true',
                icon: customAlatMarker
            });
            marker.on('dragend', function(event) {
                var marker = event.target;
                var position = marker.getLatLng();
                marker.setLatLng(new L.LatLng(position.lat, position.lng), {
                    draggable: 'true'
                });
                map.panTo(new L.LatLng(position.lat, position.lng))
                $('#latitude').val(marker.getLatLng().lat);
                $('#longitude').val(marker.getLatLng().lng);
            });
            marker.addTo(markerLayer);
            $('#latitude').val(marker.getLatLng().lat);
            $('#longitude').val(marker.getLatLng().lng);
        };


        $(document).ready(function() {
            addMarker()
        });
    </script>
@endpush
