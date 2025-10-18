<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

trait UploadFileTrait
{
    public function uploadFile(UploadedFile $file, string $folder = 'uploads/files'): string
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
        $allowedMimes = [
            'image/jpeg',
            'image/png',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
        $maxSize = 10 * 1024 * 1024;

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


        $fileName = Str::uuid() . '.' . $extension;

      $modulePath = storage_path("app/private/$folder");

        if (!is_dir($modulePath)) {
            mkdir($modulePath, 0755, true);
        }

        if (str_contains($file->getMimeType(), 'image')) {
            $img = Image::read($file)
                ->encodeByExtension($extension, quality: 90);

            $img->save("$modulePath/$fileName");
        } else {
            $file->move($modulePath, $fileName);
        }

return "$folder/$fileName";
    }
}
