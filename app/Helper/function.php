<?php

use proj4php\Proj;
use proj4php\Point;
use proj4php\Proj4php;


function getLatLng($easting, $northing){
    // Load Proj4php library
    $proj4 = new Proj4php();

    // Proyeksi UTM Zone 48S (Lampung, selatan ekuator)
    $utmProj = new Proj('EPSG:32748', $proj4);
    $wgs84Proj = new Proj('EPSG:4326', $proj4);

    // Titik dalam UTM
    $pointSrc = new Point($easting, $northing, $utmProj);

    // Transformasi ke WGS 84
    $pointDest = $proj4->transform($wgs84Proj, $pointSrc);

    // Hasil konversi
    return [
        'latitude' => round($pointDest->y, 6),
        'longitude' => round($pointDest->x, 6),
    ];
}

function global_assets_path($path)
{
    if(env('APP_ENV') == 'production'){
        $publicHtmlPath = '/home/vincenti/public_html'; 
        return str_replace(['core/public/', 'core\\public\\'], '', $publicHtmlPath . '/' .$path);
    }else{
        return str_replace(['core/public/', 'core\\public\\'], '', public_path($path));
    }
}