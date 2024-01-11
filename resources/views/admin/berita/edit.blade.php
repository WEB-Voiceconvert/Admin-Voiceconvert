@extends('layouts.admin.dashboard')
@section('title', 'Berita')
@push('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('breadcumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Berita</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">Update Berita</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-3">
                        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" id="judul" name="judul" class="form-control"
                                    value="{{ $berita->judul }}">
                            </div>
                            <div class="form-group mt-3">
                                <label for="latitude" class="form-label">Titik Koordinat</label>
                                <p style="font-size: 12px">Geser titik merah untuk mengubah titik koordinat event.</p>
                                <input type="hidden" id="latitude" name="latitude" class="form-control"
                                    value="{{ $berita->latitude }}">
                                <input type="hidden" id="longitude" name="longitude" class="form-control"
                                    value="{{ $berita->longitude }}">
                                <div id="map" style = "width: 900px; height: 580px; max-width: 100%;"></div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" accept="image/*" id="gambar" name="gambar" class="form-control">
                                <img style="max-width: 50%; width: 300px"
                                    src="{{ asset('assets/images/' . $berita->gambar) }}" alt="image">
                            </div>
                            <div class="form-group">
                                <label for="summernote" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" id="summernote" cols="30" rows="10">{{ $berita->deskripsi }}</textarea>
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
        $('#summernote').summernote({
            // placeholder: 'Hello stand alone ui',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', ]],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
    <script>
        var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        var map = L.map('map', {
            center: ['{{ $berita->latitude }}', '{{ $berita->longitude }}'],
            zoom: 9,
            scrollWheelZoom: false
        });
        map.addLayer(layer);
        var customMarker = L.icon({
            iconUrl: "{{ url('assets/images/map_green.png') }}",
            iconSize: [20, 30],
        });

        var customAlatMarker = L.icon({
            iconUrl: "{{ url('assets/images/map_blue.png') }}",
            iconSize: [40, 40],
        });

        var markerLayerAlat = L.layerGroup().addTo(map);
        var markerLayer = L.layerGroup().addTo(map);

        function addMarker() {
            markerLayer.clearLayers();
            marker = new L.marker(['{{ $berita->latitude }}', '{{ $berita->longitude }}'], {
                draggable: 'true',
                icon: customMarker
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

        function addAlatMarker(lat, lng) {
            markerAlat = new L.marker([lat, lng], {
                icon: customAlatMarker,
            });
            markerAlat.addTo(markerLayerAlat);

        }


        $(document).ready(function() {
            '@foreach ($alats as $item)'
            addAlatMarker('{{ $item->latitude }}', '{{ $item->longitude }}')
            '@endforeach'
            addMarker()
        });
    </script>
@endpush
