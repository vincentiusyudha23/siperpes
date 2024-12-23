@extends('user.user-master')

@section('title', 'GIS')

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
    </style>
@endsection

@section('content')
    <div class="w-100 h-100 position-relative overflow-hidden">
        <a href="{{ route('user.perumahan.add') }}" class="btn btn-sm btn-primary btn-add-perum">
            <i class="fa-solid fa-circle-plus"></i>
            <span class="fw-semibold">Perumahan</span>
        </a>
        <div id="map"></div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            mapboxgl.accessToken = '{{ env("MAPBOX_KEY") }}';
            const map = new mapboxgl.Map({
                container: 'map',
                center: [106.827153, -6.175110],                
                style: 'mapbox://styles/mapbox/streets-v9',
                zoom: 10,
            });

            map.addControl(new mapboxgl.NavigationControl());
        });
    </script>
@endsection