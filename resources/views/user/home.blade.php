@extends('master')

@section('title', 'Home')

@section('style')
    <style>
        #map{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 90vh;
            z-index: 1;
        }
        .map-sidebar-info{
            position: absolute;
            left: -300px;
            width: 300px;
            height: 100%;
            background: white;
            z-index: 998;
            transition: left 0.3s ease;
        }
        .map-sidebar-info.active{
            left: 0;
        }
        .sidebar-header{
            width: 100%;
        }
        .sidebar-header img{
            width: 100%;
            height: 200px;
            object-fit: cover;
            object-position: center center;
        }
        .widget-sidebar{
            width: 100%;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            padding: 15px;
        }
        .widget-item{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .widget-item:hover{
            cursor: pointer;
            scale: 0.95;
        }
        .widget-item .circle-widget{
            width: 60px;
            height: 60px;
            border-radius: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .btn-close-sidebar{
            position: absolute;
            right: 10px;
            top: 10px;
            z-index: 100;
        }
        .search-box{
            background: white;
            border-radius: 15px;
            position: absolute;
            top: 10px;
            left: 35%;
            z-index: 100;
            width: 30%;
        }
        .box-intruction-rute{
            position: fixed;
            width: 300px;
            height: 400px;
            max-height: 400px !important;
            background: rgb(255, 255, 255, 0.7);
            bottom: 20px;
            right: 10px;
            z-index: 999;
            border-radius: 15px;
            display: none;
            transition: display 0.3s ease;
        }
        .box-intruction-rute.active{
            display: block;
        }
        .box-content-itr-rute{
            width: 100%;
            height: 100%;
            padding: 10px;
        }
        @media (max-width: 768px){
            .search-box{
                left: 50%;
                top: 10%;
                transform: translate(-50%, -50%);
                z-index: 100;
                width: 50%;
            }
        }
        @media (max-width: 576px){
            .search-box{
                width: 70%;
                left: 40%;
            }
            .box-intruction-rute{
                position: fixed;
                width: 100%;
                height: 250px;
                max-height: 400px !important;
                background: white;
                bottom: -250px;
                left: 0;
                z-index: 999;
                border-radius: 15px;
                display: block;
                transition: bottom 0.3s ease;
            }
            .box-intruction-rute.active{
                bottom: 0;
            }
            .map-sidebar-info{
                position: fixed;
                width: 100%;
                height: 300px;
                max-height: 300px;
                bottom: -300px;
                left: 0;
                background: white;
                z-index: 999;
                transition: bottom 0.3s ease;
                overflow-y: scroll;
            }
            .map-sidebar-info.active{
                bottom: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="w-100 h-100 position-relative">

        <div class="search-box px-3 py-2">
            <span class="fw-semibold m-0 p-0">Pencarian</span>
            <select class="js-example-basic-single form-select" name="state">
                <option></option>
                @foreach ($markers as $item)
                    <option value="{{ $item['id'] }}">{{ $item['name'] }}, Desa {{ $item['desa'] ?? '' }}, Kec. {{ $item['kecamatan'] ?? '' }}</option>
                @endforeach
            </select>
        </div>

        <div class="map-sidebar-info rounded">
            
        </div>

        <div class="box-intruction-rute">
            <div class="w-100 d-flex justify-content-end">
                <button type="button" id="btn-close-bir" class="btn text-center btn-sm btn-danger d-flex position-absolute justify-content-center align-items-center rounded-circle" 
                        style="width: 25px; height: 25px; top: 10px; right: 10px;">
                    <span class="fw-bold">X</span>
                </button>
            </div>
            <div class="w-100 d-flex justify-content-center align-items-center" style="height: 25%;">
                <div class="d-flex gap-3 align-items-center">
                    <i class="fa-solid fa-car fa-2xl"></i>
                    <div class="d-flex flex-column gap-0">
                        <span class="fw-bold m-0 p-0" id="duration"></span>
                        <span class="fw-bold m-0 p-0" id="distance"></span>
                    </div>
                </div>
            </div>
            <div class="w-100 d-flex gap-2 px-3">
                <div class="w-50">
                    <button class="btn btn-sm btn-dark rounded-sm w-100" id="btn-rute-1">
                        Rute 1
                    </button>
                </div>
                <div class="w-50">
                    <button class="btn btn-sm btn-dark rounded-sm w-100" id="btn-rute-2">
                        Rute 2
                    </button>
                </div>
            </div>
            <div class="box-content-itr-rute">
                <div class="w-100 overflow-y-auto" style="max-height: 65%;">
                    <ul class="list-group list-group-numbered" id="intruction-list">
                        
                    </ul>
                </div>
            </div>
        </div>

        <div id="map"></div>
    </div>
@endsection

@section('script')
    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif
  
    <script>
        $(document).ready(function(){
            $('.js-example-basic-single').select2({
                placeholder: 'Pilih Perumahan'
            });
            mapboxgl.accessToken = '{{ env("MAPBOX_KEY") }}';
            const map = new mapboxgl.Map({
                container: 'map',
                center: [105.156517,-5.365298],                
                style: 'mapbox://styles/mapbox/streets-v9',
                zoom: 10,
            });

            map.addControl(new mapboxgl.NavigationControl());

            const markers = @json($markers);

            map.on('load', () => {
                // Mendaftarkan ikon rumah
                map.loadImage('{{ asset("asset/img/icon-perum.png") }}', (error, image) => {
                    if (error) throw error;
                    map.addImage('house-icon', image);
                    
                    // Tambahkan source data
                    map.addSource('perumahan', {
                        type: 'geojson',
                        data: {
                            type: 'FeatureCollection',
                            features: markers.map(mark => ({
                                type: 'Feature',
                                geometry: mark.point,
                                properties: {
                                    id: mark.id,
                                    title: mark.name,
                                    description: '....',
                                    polygon: mark.polygon
                                }
                            }))
                        }
                    });

                    // Tambahkan layer untuk ikon rumah
                    map.addLayer({
                        'id': 'perumahan-icons',
                        'type': 'symbol',
                        'source': 'perumahan',
                        'layout': {
                            'icon-image': 'house-icon',
                            'icon-size': 0.2,
                            'icon-allow-overlap': true,
                            'text-field': ['get', 'title'],
                            'text-size': 12,
                            'text-offset': [0, -1.5],
                            'text-anchor': 'top',
                            'text-allow-overlap': false,
                            'text-optional': true
                        },
                        'paint': {
                            'text-color': '#000',
                            'text-halo-color': '#fff',
                            'text-halo-width': 2
                        }
                    });

                    // Tambahkan popup saat klik
                    map.on('click', 'perumahan-icons', (e) => {
                        const coordinates = e.features[0].geometry.coordinates.slice();
                        const description = e.features[0].properties.description;
                        const polygonData = e.features[0].properties.polygon;
                        const id = e.features[0].properties.id;
                        var box_int = $('.box-intruction-rute');

                        if(box_int.hasClass('active')){
                            box_int.removeClass('active');
                        }

                        $.ajax({
                            type: 'GET',
                            url: '{{ route("getInfoPerumahan", ["id" => 'id']) }}'.replace('id', id),
                            success: function(response){
                                var sidebar_info = $('.map-sidebar-info');

                                if(response.status == 'success'){
                                    sidebar_info.html(response.markup);
                                    sidebar_info.addClass('active');
                                }
                            },
                            complete: function(){
                                map.flyTo({
                                    center: coordinates,
                                    zoom: 16,
                                    essential: true
                                });

                                if (map.getLayer('polygon-layer')) {
                                    map.removeLayer('polygon-layer');
                                    map.removeSource('polygon-source');
                                }

                                map.addSource('polygon-source', {
                                    type: 'geojson',
                                    data: JSON.parse(polygonData)
                                });

                                map.addLayer({
                                    'id': 'polygon-layer',
                                    'type': 'fill',
                                    'source': 'polygon-source',
                                    'layout': {},
                                    'paint': {
                                        'fill-color': '#0080ff',
                                        'fill-opacity': 0.4
                                    }
                                });
                            }
                        });
                    });

                    // Change cursor on hover
                    map.on('mouseenter', 'perumahan-icons', () => {
                        map.getCanvas().style.cursor = 'pointer';
                    });
                    map.on('mouseleave', 'perumahan-icons', () => {
                        map.getCanvas().style.cursor = '';
                    });
                });
            });

            $(document).on('click', '.btn-close-sidebar', function(){
                $('.map-sidebar-info').removeClass('active');
            });

             $('.js-example-basic-single').on('change', function(){
                const select_perum = $(this).val();
                const selectedPerum = markers.find(
                    (item) => item.id == select_perum
                );

                map.flyTo({
                    center: selectedPerum.point.coordinates,
                    zoom: 16,
                    essential: true
                });
                
            })

            var start = [105.3247127,-5.4142];
            var route_json;

            $(document).on('click', '.route-btn', function() {
                var el = $(this);
                var id = el.data('id');
                var selectedPerum = markers.find(
                    (item) => item.id == id
                );

                
                var end = selectedPerum.point.coordinates;
                getRoute(end);
                $('.btn-close-sidebar').trigger('click');
            });
            
            
            async function getRoute(end) {
                const query = await fetch(
                    `https://api.mapbox.com/directions/v5/mapbox/driving/${start[0]},${start[1]};${end[0]},${end[1]}?alternatives=true&steps=true&geometries=geojson&language=id&overview=full&access_token=${mapboxgl.accessToken}`,
                    { method: 'GET' }
                );
                route_json = await query.json();
                setRoute(0);

                var box_int = $('.box-intruction-rute');

                if(!box_int.hasClass('active')){
                    box_int.addClass('active');
                }
            };

            function formatDuration(seconds) {
                const hours = Math.floor(seconds / 3600); // Hitung jam
                const minutes = Math.floor((seconds % 3600) / 60); // Hitung menit
                const remainingSeconds = Math.floor(seconds % 60); // Hitung detik

                let result = '';
                if (hours > 0) result += `${hours} jam, `;
                if (minutes > 0) result += `${minutes} menit, `;
                if (remainingSeconds > 0) result += `${remainingSeconds} detik`;

                return result.trim();
            }

            function formatDistance(dist){
                if (dist > 1000) {
                    return `${ Math.floor(dist/1000) } KM`;
                }else{
                     return `${ Math.floor(dist) } M`;
                }
            }

            function setRoute(rute){
                const data = route_json.routes[rute];
                const route = data.geometry.coordinates;
                const geojson = {
                    type: 'Feature',
                    properties: {},
                    geometry: {
                    type: 'LineString',
                    coordinates: route
                    }
                };

                const intruction = data.legs[0].steps;
                $('#intruction-list').empty();
                intruction.map(function(step){
                    $('#intruction-list').append(`<li class="fw-semibold list-group-item">${step.maneuver.instruction}</li>`)
                });

                $('.box-intruction-rute').addClass('active');

                $('#duration').text(formatDuration(data.duration));
                $('#distance').text(formatDistance(data.distance));
                if (map.getSource('route')) {
                    map.getSource('route').setData(geojson);
                }else {
                    map.addLayer({
                        id: 'route',
                        type: 'line',
                        source: {
                            type: 'geojson',
                            data: geojson
                        },
                        layout: {
                            'line-join': 'round',
                            'line-cap': 'round'
                        },
                        paint: {
                            'line-color': '#3887be',
                            'line-width': 5,
                            'line-opacity': 0.75
                        }
                    });
                }

                map.flyTo({
                    center : start,
                    zoom: 12,
                    essential: true
                });
            }

            $(document).on('click', '#btn-rute-1', function(){
                setRoute(0);
            });
            $(document).on('click', '#btn-rute-2', function(){
                setRoute(1);
            });
            $(document).on('click', '#btn-close-bir', function(){
                var box_int = $('.box-intruction-rute');

                if(box_int.hasClass('active')){
                    box_int.removeClass('active');
                }
            });

        });
    </script>
@endsection