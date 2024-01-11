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
        <h6 class="font-weight-bolder mb-0">View Event</h6>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4 px-3">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h3>{{ $event->nama_event }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless" style="max-width: 500px">
                                <tbody>
                                    <tr>
                                        <td>Kategori</td>
                                        <td>:</td>
                                        <td>{{ $event->category->nama_kategori }}</td>
                                    </tr>
                                    <tr>
                                        <td>Lokasi</td>
                                        <td>:</td>
                                        <td>{{ $event->lokasi }}</td>
                                    </tr>
                                    <tr>
                                        <td>Titik Koordinat</td>
                                        <td>:</td>
                                        <td>{{ $event->latitude }}, {{ $event->longitude }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Event</td>
                                        <td>:</td>
                                        <td>{{ $event->tgl_event }}</td>
                                    </tr>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td>:</td>
                                        <td>{{ $event->deskripsi }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div id="map" style = "width: 900px; height: 580px; max-width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h3>List Voice</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addVoice">Tambah</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table w-100 mb-0">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Voice</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($event->voices as $voice)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $voice->filename }}</td>
                                            <td><audio controls class="w-100">
                                                    <source src="{{ asset('assets/voices/' . $voice->filename) }}">
                                                </audio>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('operator.event.voice.delete', $voice->id) }}"
                                                    class="text-danger"><i class="fa-regular fa-trash-can"></i></a>
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
        <!-- Modal to add voice -->
        <div class="modal fade" id="addVoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('operator.event.voice.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Voice</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="namaVoice" class="form-label">Nama Voice</label>
                                <input type="text" class="form-control" id="namaVoice" name="nama_voice" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="fileVoice" class="form-label">File Voice</label>
                                <input type="file" accept="audio/*" class="form-control" id="fileVoice" name="file_voice"
                                    required>
                            </div>
                            <input type="hidden" name="id_event" value="{{ $event->id }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
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
            zoom: 9,
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
