<?php
$routes = [
    'getDrivingDuration',
    'getDrivingTrafficDuration',
    'getWalkingDuration',
    'getCyclingDuration',
    'metadata',
];
foreach ($routes as $file) {
    require __DIR__ . '/../src/routes/' . $file . '.php';
}
