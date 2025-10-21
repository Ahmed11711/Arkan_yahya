<?php

return [

    'paths' => ['*'], // أي مسار
    'allowed_methods' => ['*'], // أي method
    'allowed_origins' => ['*'], // أي domain
    'allowed_origins_patterns' => ['*'], 
    'allowed_headers' => ['*'], // أي headers
    'exposed_headers' => ['*'], // أي headers ممكن يشوفها المتصفح
    'max_age' => 0,
    'supports_credentials' => false, // مهم هنا
];
