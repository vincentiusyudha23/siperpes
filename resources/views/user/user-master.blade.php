<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') - SIPERPES</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/ccf5b15bef.js" crossorigin="anonymous"></script>
        <link href="https://api.mapbox.com/mapbox-gl-js/v3.9.0/mapbox-gl.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v3.9.0/mapbox-gl.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        
        @yield('style')
        <style>
            body{
                margin: 0;
                padding: 0;
            }
            .sidebar-admin{
                width: 20%;
                height: 90vh;
                display: block;
            }
            .content-admin{
                width: 80%;
                max-height: 90vh;
                overflow: hidden;
            }
            .btn-menu{
                position: absolute;
                width: 100%;
                bottom: -15px;
                display: none;
                justify-content: center;
                align-items: center;
                z-index: 4;
            }
            .upbar{
                width: 100%;
                height: 0;
                display: none;
                position: absolute;
                bottom: -120px;
                z-index: 3;
            }
            .upbar.active{
                height: auto;
                display: block;
                transition: height 0.2s ease;
            }
            @media (max-width: 768px){
                .sidebar-admin{
                    display: none;
                }
                .content-admin{
                    width: 100%;
                    height: 90vh;
                    overflow-y: scroll;
                }
                .btn-menu{
                    display: flex;
                }
            }
        </style>
    </head>
    <body>

        @include('partials.user-navbar')

        <div class="w-100 h-100 d-flex">
            <div class="sidebar-admin bg-primary">
                @include('partials.sidebar')
            </div>
            <div class="content-admin">
                @yield('content')
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        @yield('script')
        <script>
            $(document).ready(function(){
                $('#btn-menu-upbar').on('click', function(){
                    $('.upbar').toggleClass('active');
                });
            });
        </script>
    </body>
</html>
