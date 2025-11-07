<?php

namespace App\Http\Resources\Admin\UserKyc;

use Illuminate\Http\Resources\Json\JsonResource;

class UserKycResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'front_id' => $this->buildImagePath($this->front_id),
            'back_id' => $this->buildImagePath($this->back_id),
            'face' => $this->buildImagePath($this->face),
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function buildImagePath(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        // استخراج اسم الملف من المسار الأصلي
        $filename = basename($url);

        // تكوين المسار الجديد
        return "https://back.zayamrock.com/storage/app/public/Kyc/" . $filename;
    }
}
