@extends('layouts.admin.dashboard')
@section('title', 'Alat')
@push('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('breadcumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Alat</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">Tambah Alat</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-3">
                        <form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="lokasi" class="form-label">Lokasi Alat</label>
                                <input type="text" id="lokasi" name="lokasi" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label for="latitude" class="form-label">Titik Koordinat</label>
                                <p style="font-size: 12px">Geser titik biru untuk mengubah titik koordinat alat.</p>
                                <input type="hidden" id="latitude" name="latitude" class="form-control">
                                <input type="hidden" id="longitude" name="longitude" class="form-control">
                                <div id="map" style = "width: 900px; height: 580px; max-width: 100%;"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
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
            center: [-7.5608300666665125, 110.85657409249544],
            zoom: 9,
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
            marker = new L.marker([-7.5608300666665125, 110.85657409249544], {
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
