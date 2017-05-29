<?php
$routes = [
    'testDataTypes',
    'getDrivingDuration',
    'getDrivingDurationByFile',
    'getWalkingDuration',
    'getWalkingDurationByFile',
    'getCyclingDuration',
    'getCyclingDurationByFile',
    'metadata'
];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}

