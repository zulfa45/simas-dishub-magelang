<?php

namespace App\Services;

use App\Models\IncomingLetter;
use App\Models\LetterAttachment;
use App\Models\LetterHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class LetterService
{
    /**
     * Create a new incoming letter with history.
     */
    public function createLetter(array $data, $userId)
    {
        return DB::transaction(function () use ($data, $userId) {
            $data['created_by'] = $userId;
            $data['status'] = 'baru';
            
            $letter = IncomingLetter::create($data);

            $this->recordHistory(
                $letter->id,
                $userId,
                'created',
                'Surat masuk baru didaftarkan'
            );

            return $letter;
        });
    }

    /**
     * Upload an attachment to a letter.
     */
    public function uploadAttachment(IncomingLetter $letter, UploadedFile $file, $userId)
    {
        return DB::transaction(function () use ($letter, $file, $userId) {
            // Use private disk as requested
            $path = $file->store('private/attachments');

            $attachment = LetterAttachment::create([
                'incoming_letter_id' => $letter->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'uploaded_by' => $userId,
            ]);

            $this->recordHistory(
                $letter->id,
                $userId,
                'attachment_added',
                'Lampiran baru ditambahkan: ' . $attachment->file_name
            );

            return $attachment;
        });
    }

    /**
     * Record a history entry for a letter.
     */
    public function recordHistory($letterId, $userId, $activity, $description, $relatedType = null, $relatedId = null, $metadata = null)
    {
        return LetterHistory::create([
            'incoming_letter_id' => $letterId,
            'user_id' => $userId,
            'activity' => $activity,
            'description' => $description,
            'related_type' => $relatedType,
            'related_id' => $relatedId,
            'metadata' => $metadata,
        ]);
    }
}