<?php

return [
    'temporary_file_upload' => [
        'disk' => null,        
        'rules' => null,
        'directory' => null,
        'middleware' => null,
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'avif', // <--- This solves your error
        ],
        'max_upload_time' => 5,
    ],
];