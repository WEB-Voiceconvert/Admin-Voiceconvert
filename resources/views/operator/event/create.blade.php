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
        <h6 class="font-weight-bolder mb-0">Tambah Event</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-3">
                        <form action="{{ route('operator.event.store') }}" method="POST">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="nama" class="form-label">Nama Event</label>
                                <input type="text" id="nama" name="nama" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="nama" class="form-label">Kategori</label>
                                <select class="form-select" aria-label=".form-select-sm example" id="category"
                                    name="category" required>
                                    <option selected>Pilih Kategori</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input type="text" id="lokasi" name="lokasi" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="lokasi" class="form-label">Titik Koordinat</label>
                                <p style="font-size: 12px">Geser titik kuning untuk mengubah titik koordinat event.</p>
                                <input type="hidden" id="lat" name="lat" value="">
                                <input type="hidden" id="lng" name="lng" value="">
                                <div id="map" style = "width: 900px; height: 580px; max-width: 100%;"></div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="tglEvent" class="form-label">Tanggal</label>
                                <input type="date" id="tglEvent" name="tgl_event" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>

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
        var customMarker = L.icon({
            iconUrl: "{{ url('assets/images/map_yellow.png') }}",
            iconSize: [40, 40],
        });

        var customAlatMarker = L.icon({
            iconUrl: "{{ url('assets/images/map_blue.png') }}",
            iconSize: [40, 40],
        });

        var markerLayerAlat = L.layerGroup().addTo(map);
        var markerLayer = L.layerGroup().addTo(map);

        function addMarker() {
            markerLayer.clearLayers();
            marker = new L.marker([-7.5608300666665125, 110.85657409249544], {
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
                $('#lat').val(marker.getLatLng().lat);
                $('#lng').val(marker.getLatLng().lng);
            });
            marker.addTo(markerLayer);
            $('#lat').val(marker.getLatLng().lat);
            $('#lng').val(marker.getLatLng().lng);
        };

        function addAlatMarker(lat, lng) {
            markerAlat = new L.marker([lat, lng], {
                icon: customAlatMarker,
            });
            var newpopup = L.popup({
                autoClose: false
            }).setContent("Lokasi Alat");
            markerAlat.addTo(markerLayerAlat);
            markerAlat.bindPopup(newpopup).openPopup();

        }


        $(document).ready(function() {
            '@foreach ($alats as $item)'
            addAlatMarker('{{ $item->latitude }}', '{{ $item->longitude }}')
            '@endforeach'
            addMarker()
        });
    </script>
@endpush
