<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'تصميم مواقع إلكترونية',
                'desc' => 'نقوم بتصميم مواقع احترافية متكاملة.',
                'img' => 'services/web_design.jpg',
                'push' => true,
                'push_date' => now()->addDays(5),
            ],
            [
                'title' => 'تطوير تطبيقات الجوال',
                'desc' => 'نطوّر تطبيقات سهلة الاستخدام وسريعة.',
                'img' => 'services/mobile_dev.jpg',
                'push' => false,
                'push_date' => now()->addDays(5),
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
