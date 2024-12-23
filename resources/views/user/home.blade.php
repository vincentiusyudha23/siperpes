@extends('master')

@section('title', 'Home')

@section('style')
    <style>
        #map{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 88vh;
            z-index: 1;
        }
        .btn-add-perum{
            position: absolute;
            top: 15px;
            right: 50px;
            z-index: 2;
        }
        .map-sidebar-info{
            position: absolute;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100%;
            background: white;
            z-index: 3;
            transition: left 0.3s ease;
            overflow-y: scroll;
        }
        .map-sidebar-info.active{
            left: 0;
            top: 0;
        }
        .sidebar-header{
            width: 100%;
        }
        .sidebar-header img{
            width: 100%;
            height: 200px;
            object-fit: cover;
            object-position: center center;
            border-radius: 0 10px 0 0;
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
    </style>
@endsection

@section('content')
    <div class="w-100 h-100 position-relative overflow-hidden">
        
        <div class="map-sidebar-info rounded-end shadow-sm">
            
        </div>
        <div class="search-box px-3 py-2">
            <span class="fw-semibold m-0 p-0">Pencarian</span>
            <select class="js-example-basic-single form-select" name="state">
                <option></option>
                @foreach ($markers as $item)
                    <option value="{{ $item['id'] }}">{{ $item['name'] }}, Desa {{ $item['desa'] }}, Kec. {{ $item['kecamatan'] }}</option>
                @endforeach
            </select>
        </div>
        <div id="map"></div>
    </div>
@endsection

@section('script')
  
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
                                    map.removeLayer('polygon-layer'); // Hapus layer sebelumnya jika ada
                                    map.removeSource('polygon-source');
                                }

                                map.addSource('polygon-source', {
                                    type: 'geojson',
                                    data: JSON.parse(polygonData) // Gunakan data polygon
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

        });
    </script>
@endsection