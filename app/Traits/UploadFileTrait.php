<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

trait UploadFileTrait
{
    public function uploadFile(UploadedFile $file, string $folder = 'uploads/Service'): string
    {
        // أنواع الملفات المسموح بها
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
        $allowedMimes = [
            'image/jpeg', 'image/png',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
        $maxSize = 10 * 1024 * 1024; // 10MB

        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions)) {
            throw new \Exception('File type not allowed.');
        }

        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \Exception('Invalid MIME type.');
        }

        if ($file->getSize() > $maxSize) {
            throw new \Exception('File too large.');
        }

        if (preg_match('/\.(php|js|exe|sh)$/i', $file->getClientOriginalName())) {
            throw new \Exception('Executable files are not allowed.');
        }

        // اسم الملف النهائي
        $fileName = Str::uuid() . '.' . $extension;

        // المجلد على القرص public
        $disk = 'public';

        if (str_contains($file->getMimeType(), 'image')) {
            $img = Image::read($file)
                ->encodeByExtension($extension, quality: 90);
            Storage::disk($disk)->put("$folder/$fileName", (string) $img);
        } else {
            Storage::disk($disk)->putFileAs($folder, $file, $fileName);
        }

        // الرابط النهائي للفرنت
        return Storage::disk($disk)->url("$folder/$fileName");
    }
}
