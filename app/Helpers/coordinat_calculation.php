<?php

function getNewLat($oldLat)
{
    $meters = 500;

    // Earth radius in meters
    $earthRadius = 6371000; // approximately

    // Convert latitude from degrees to radians
    $oldLatitudeRad = deg2rad($oldLat);

    // Calculate the angular distance in radians
    $angularDistance = $meters / $earthRadius;

    // Calculate the new latitude in radians
    $newLatitudeRad = $oldLatitudeRad + $angularDistance;

    // Convert the new latitude back to degrees
    $newLatitude = rad2deg($newLatitudeRad);

    return $newLatitude;
}
function getNewLng($oldLat, $oldLng)
{
    $meters = 500;

    // Earth radius in meters
    $earthRadius = 6371000; // approximately

    // Convert latitudes and longitudes from degrees to radians
    $oldLatitudeRad = deg2rad($oldLat);
    $oldLongitudeRad = deg2rad($oldLng);

    // Calculate the angular distance in radians
    $angularDistance = $meters / $earthRadius;

    // Calculate the new latitude in radians
    $newLatitudeRad = $oldLatitudeRad;

    // Calculate the change in longitude
    $deltaLongitude = asin(sin($angularDistance) / cos($oldLatitudeRad));

    // Calculate the new longitude in radians
    $newLongitudeRad = $oldLongitudeRad + $deltaLongitude;

    // Convert the new longitude back to degrees
    $newLongitude = rad2deg($newLongitudeRad);

    return $newLongitude;
}

function getRadius($lat1, $lon1, $lat2, $lon2)
{

    $earthRadius = 6371000; // Earth radius in meters

    // Convert latitude and longitude from degrees to radians
    $lat1Rad = deg2rad($lat1);
    $lon1Rad = deg2rad($lon1);
    $lat2Rad = deg2rad($lat2);
    $lon2Rad = deg2rad($lon2);

    // Calculate differences in coordinates
    $latDiff = $lat2Rad - $lat1Rad;
    $lonDiff = $lon2Rad - $lon1Rad;

    // Haversine formula
    $a = sin($latDiff / 2) * sin($latDiff / 2) +
        cos($lat1Rad) * cos($lat2Rad) *
        sin($lonDiff / 2) * sin($lonDiff / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    // Calculate the distance
    $distance = $earthRadius * $c;

    return $distance;
}
