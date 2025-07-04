<?php

return [
    'theme' => [
        'fontFamily' => [
            'sans' => ['ui-sans-serif', 'system=ui']
        ]
    ],
    'content' => [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    'theme' => [
        'extend' => [
            'screens' => [
                'mobile' => ['max' => '480px'],
                'tablet' => ['max' => '1023px', 'min' => '481px'],
                'desktop' => ['min' => '1024px'],
            ],
            'colors' => [
                'primary' => "#2196f3",
                'primary-transparent' => "#2196f330",
            ]
        ]
    ],
];