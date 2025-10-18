<?
namespace App\Traits;

use Modules\Performance\Models\PerformanceAttachment;

trait HasAttachmentsTrait
{
    public function attachments()
    {
        return $this->morphMany(PerformanceAttachment::class, 'attachable');
    }

    public function addAttachments($files, $reference = null)
    {
        $attachments = [];
        foreach ($files as $file) {
            $path = $file->store('uploads', 'public');

            $attachments[] = $this->attachments()->create([
                'name'             => $file->getClientOriginalName(),
                'file'             => $path,
                'reference_number' => $reference,
                'size'             => $file->getSize(),
                'mime_type'        => $file->getMimeType(),
            ]);
        }
        return $attachments;
    }
}

