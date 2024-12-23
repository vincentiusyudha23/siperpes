@extends('user.user-master')

@section('title', 'Add Perum')

@section('style')
    <script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.5.0/mapbox-gl-draw.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.5.0/mapbox-gl-draw.css" type="text/css">
    <style>
        #map{
            width: 100%;
            height: 500px;
        }
        .calculation-box {
            height: 75px;
            width: 150px;
            position: absolute;
            bottom: 70px;
            left: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 15px;
            text-align: center;
        }

        p {
            font-family: 'Open Sans';
            margin: 0;
            font-size: 13px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-2">
        <div class="mb-3">
            <div class="card w-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h1 class="fw-semibold text-secondary">Tambah Perumahan</h1>
                    <a href="{{ route('user.perumahan') }}" class="btn btn-sm btn-danger fw-semibold">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="">
            <div class="card w-100">
                <div class="card-body">
                    <form method="POST" action="{{ route('user.perumahan.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold">Nama Perumahan</label>
                            <input type="text" class="form-control" name="name_perum" value="{{ old('name_perum') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold">Nama Pengembang</label>
                            <input type="text" class="form-control" name="name_pengembang" value="{{ old('name_pengembang') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold">Image</label>
                            <input type="file" class="form-control" name="image" value="{{ old('image') }}" accept="image/*">
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <div>
                                    <label class="form-label text-secondary fw-semibold">Desa</label>
                                    <input type="text" class="form-control" name="desa" value="{{ old('desa') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div>
                                    <label class="form-label text-secondary fw-semibold">Kecamatan</label>
                                    <input type="text" class="form-control" name="kecamatan" value="{{ old('kecamatan') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div>
                                    <label class="form-label text-secondary fw-semibold">Jumlah Unit/Rumah</label>
                                    <input type="number" class="form-control" name="jumlah_unit" value="{{ old('jumlah_unit') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div>
                                    <label class="form-label text-secondary fw-semibold">Tahun Berdiri</label>
                                    <input type="number" class="form-control" name="tahun_berdiri" value="{{ old('tahun_berdiri') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div>
                                    <label class="form-label text-secondary fw-semibold">Easting(UTM)</label>
                                    <input type="number" class="form-control" name="easting" value="{{ old('easting') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div>
                                    <label class="form-label text-secondary fw-semibold">Norting(UTM)</label>
                                    <input type="number" class="form-control" name="norting" value="{{ old('norting') }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <button type="button" class="btn btn-sm btn-light w-100" id="btn-lokasi">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    Cari Lokasi
                                </button>
                            </div>
                        </div>

                        <div class="w-100 mb-3">
                            <div id="map"></div>
                            <div class="calculation-box">
                                <p>Click the map to draw a polygon.</p>
                                <div id="calculated-area"></div>
                            </div>
                        </div>
                        <input type="hidden" id="polygon-field" name="polygon">
                        <button type="submit" class="btn btn-success w-100 fw-semibold">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            mapboxgl.accessToken = "{{ env('MAPBOX_KEY') }}";
            const map = new mapboxgl.Map({
                container: 'map', // container ID
                style: 'mapbox://styles/mapbox/satellite-v9', // style URL
                center: [105.156517,-5.365298], // starting position [lng, lat]
                zoom: 10 // starting zoom
            });

            const draw = new MapboxDraw({
                displayControlsDefault: false,
                // Select which mapbox-gl-draw control buttons to add to the map.
                controls: {
                    polygon: true,
                    trash: true
                },
                // Set mapbox-gl-draw to draw by default.
                // The user does not have to click the polygon control button first.
                defaultMode: 'draw_polygon'
            });
            map.addControl(draw);

            map.on('draw.create', updateArea);
            map.on('draw.delete', updateArea);
            map.on('draw.update', updateArea);

            function updateArea(e) {
                const data = draw.getAll();
                const answer = document.getElementById('calculated-area');
                if (data.features.length > 0) {
                    const area = turf.area(data);
                    // Restrict the area to 2 decimal points.
                    const rounded_area = Math.round(area * 100) / 100;
                    answer.innerHTML = `<p><strong>${rounded_area}</strong></p><p>square meters</p>`;
                    const geojson = JSON.stringify(data.features[0].geometry);
                    
                    $('input[name="polygon"]').val(geojson);
                    
                } else {
                    answer.innerHTML = '';
                    if (e.type !== 'draw.delete')
                        alert('Click the map to draw a polygon.');
                }
            }

            $('#btn-lokasi').on('click', function(){
                var el = $(this);
                var east = $('input[name="easting"]').val();
                var nort = $('input[name="norting"]').val();
                var spinner = '<i class="fa-solid fa-spinner fa-spin"></i>';
                var real_tag = el.html();

                if(!east && !nort){
                    toastr.error('Easting/Norting tidak boleh kosong!');
                    return;
                }
                el.html(spinner);
                $.ajax({
                    url: '{{ route("user.getlatlng-req") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        east: east,
                        nort: nort
                    },
                    success: function(response){
                        if(response.status == 'success'){
                            const lng = response.data.longitude;
                            const lat = response.data.latitude;

                            map.flyTo({
                                center: [lng, lat],
                                zoom: 18,
                                essential: true
                            });

                            new mapboxgl.Marker()
                                .setLngLat([lng, lat])
                                .addTo(map);
                        }
                    },
                    complete: function(){
                        el.html(real_tag);
                    }
                });
            });
        });
    </script>
@endsection