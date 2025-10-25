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
    // 🧩 إعدادات الأمان
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
    $allowedMimes = [
        'image/jpeg', 'image/png',
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    $maxSize = 10 * 1024 * 1024; // 10MB

    $extension = strtolower($file->getClientOriginalExtension());
    $mime = $file->getMimeType();
    $fileName = Str::uuid() . '.' . $extension;

    // ✅ التحقق من نوع الملف
    if (!in_array($extension, $allowedExtensions)) {
        throw new \Exception('File type not allowed.');
    }

    // ✅ التحقق من نوع الـ MIME
    if (!in_array($mime, $allowedMimes)) {
        throw new \Exception('Invalid MIME type.');
    }

    // ✅ التحقق من الحجم
    if ($file->getSize() > $maxSize) {
        throw new \Exception('File too large.');
    }

    // ✅ منع الملفات التنفيذية
    if (preg_match('/\.(php|js|exe|sh)$/i', $file->getClientOriginalName())) {
        throw new \Exception('Executable files are not allowed.');
    }

    // 📁 تحديد الـ Disk
    $disk = 'public';

    // 🖼️ لو الصورة → نضغطها ونرفعها
    if (str_contains($mime, 'image')) {
        $img = Image::read($file)->encodeByExtension($extension, quality: 90);
        Storage::disk($disk)->put("$folder/$fileName", (string) $img);
    } else {
        Storage::disk($disk)->putFileAs($folder, $file, $fileName);
    }

    // ✅ المسار داخل storage
    $storedPath = "$folder/$fileName";

    // 🔗 الرابط النهائي القابل للعرض في الفرنت
    return Storage::disk($disk)->url($storedPath);
}

}
