<?php
$routes = [
    'getDrivingDurationRoute',
    'getDrivingDurationRouteByFile',
    'getWalkingDurationRoute',
    'getWalkingDurationRouteByFile',
    'getCyclingDurationRoute',
    'getCyclingDurationRouteByFile',
    'metadata'
];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}

