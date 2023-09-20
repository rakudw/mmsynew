<?php

return [
    'characters' => ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'M', 'N', 'P', 'R', 'T', 'U', 'X', 'Y', 'Z'],
    'default' => [
        'length' => 4,
        'width' => 120,
        'height' => 38,
        'quality' => 90,
        'math' => false,
        'expire' => 60,
        'encrypt' => false,
        'bgColor' => '#ecf2f4',
        'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
    ],
    'math' => [
        'length' => 9,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => true,
    ],

    'flat' => [
        'length' => 6,
        'width' => 160,
        'height' => 46,
        'quality' => 90,
        'lines' => 1,
        'bgImage' => false,
        'bgColor' => '#ecf2f4',
        'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
        'contrast' => -5,
    ],
    'mini' => [
        'length' => 3,
        'width' => 60,
        'height' => 32,
    ],
    'inverse' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'sensitive' => true,
        'angle' => 12,
        'sharpen' => 10,
        'blur' => 2,
        'invert' => true,
        'contrast' => -5,
    ]
];
