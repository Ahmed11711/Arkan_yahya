<?php

return [

    'paths' => ['*'], // أي مسار
    'allowed_methods' => ['*'], // أي method
    'allowed_origins' => [
        'http://localhost:3000',   // React (اللي بيستخدم الكوكيز)
        'http://127.0.0.1:3000',   // React أحيانًا بيستخدم الـ IP بدل localhost
        'http://localhost:5173',   // لو بتستخدم Vite أو Next.js
        'http://127.0.0.1:5173',   // Vite بالـ IP
        'http://localhost:8000',   // Laravel محلي
        'http://127.0.0.1:8000',   // Laravel بالـ IP
        'https://zayamrock.com/home', // موقع الشريك بدون كوكيز
    ],
    'allowed_origins_patterns' => ['*'], 
    'allowed_headers' => ['*'], // أي headers
    'exposed_headers' => ['*'], // أي headers ممكن يشوفها المتصفح
    'max_age' => 0,
    'supports_credentials' => true, // مهم هنا

    //ahmed
];
