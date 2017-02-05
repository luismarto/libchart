<?php
require_once '../common.php';

$chart = new Libchart\Chart\Bar([
    'chart' => [
        'width' => 500,
        'height' => 250,
    ],
    'title' => [
        'text' => 'User agents for www.example.com'
    ],
    'dataset' => [
        [],
    ]
]);
$chart->render();
