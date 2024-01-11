@extends('layouts.admin.dashboard')
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
        <h6 class="font-weight-bolder mb-0">Update Event</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-3">
                        <form action="{{ route('admin.event.update', $event->id) }}" method="POST">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="nama" class="form-label">Nama Event</label>
                                <input type="text" id="nama" name="nama" class="form-control"
                                    value="{{ $event->nama_event }}" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="nama" class="form-label">Kategori</label>
                                <select class="form-select" aria-label=".form-select-sm example" id="category"
                                    name="category" required>
                                    <option selected>Pilih Kategori</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}"
                                            @if ($item->id == $event->id_category) selected @endif>
                                            {{ $item->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input type="text" id="lokasi" name="lokasi" class="form-control"
                                    value="{{ $event->lokasi }}" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="lokasi" class="form-label">Titik Koordinat</label>
                                <p style="font-size: 12px">Geser titik merah untuk mengubah titik koordinat event.</p>
                                <input type="hidden" id="lat" name="lat" value="{{ $event->latitude }}">
                                <input type="hidden" id="lng" name="lng" value="{{ $event->longitude }}">
                                <div id="map" style = "width: 900px; height: 580px; max-width: 100%;"></div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="tglEvent" class="form-label">Tanggal</label>
                                <input type="date" id="tglEvent" name="tgl_event" class="form-control"
                                    value="{{ $event->tgl_event }}" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control">{{ $event->deskripsi }}</textarea>
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
            center: ['{{ $event->latitude }}', '{{ $event->longitude }}'],
            zoom: 10,
            scrollWheelZoom: false
        });
        map.addLayer(layer);
        var customMarker = L.icon({
            iconUrl: 'https://static.vecteezy.com/system/resources/thumbnails/016/314/482/small/map-pointer-art-icons-and-graphics-free-png.png',
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
            var newpopup = L.popup({
                autoClose: false
            }).setContent("Lokasi Event");
            marker = new L.marker(['{{ $event->latitude }}', '{{ $event->longitude }}'], {
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
            marker.bindPopup(newpopup).openPopup();
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
