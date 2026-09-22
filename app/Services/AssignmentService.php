<?php

namespace App\Services;

use App\Models\Assignment;
use App\Models\AssignmentRecipient;
use App\Models\AssignmentResponse;
use App\Models\IncomingLetter;
use Illuminate\Support\Facades\DB;

class AssignmentService
{
    protected $letterService;

    public function __construct(LetterService $letterService)
    {
        $this->letterService = $letterService;
    }

    /**
     * Create a new assignment.
     */
    public function createAssignment(IncomingLetter $letter, array $data, array $recipients, $userId)
    {
        return DB::transaction(function () use ($letter, $data, $recipients, $userId) {
            $data['incoming_letter_id'] = $letter->id;
            $data['created_by'] = $userId;
            $data['status'] = 'belum_dibaca';

            $assignment = Assignment::create($data);

            $recipientData = array_map(function ($recipient) use ($assignment) {
                return [
                    'assignment_id' => $assignment->id,
                    'department_id' => $recipient['department_id'] ?? null,
                    'user_id' => $recipient['user_id'] ?? null,
                    'recipient_type' => $assignment->recipient_type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $recipients);

            AssignmentRecipient::insert($recipientData);

            // Update letter status
            $letter->update(['status' => 'didistribusikan']);

            // Record history
            $this->letterService->recordHistory(
                $letter->id,
                $userId,
                'assignment_created',
                'Surat telah didisposisikan/ditugaskan: ' . $assignment->title,
                Assignment::class,
                $assignment->id
            );

            return $assignment;
        });
    }

    /**
     * Submit a response to an assignment.
     */
    public function submitResponse(Assignment $assignment, array $data, $userId)
    {
        return DB::transaction(function () use ($assignment, $data, $userId) {
            $data['assignment_id'] = $assignment->id;
            $data['user_id'] = $userId;

            $response = AssignmentResponse::create($data);

            // Update assignment status based on response (e.g. dalam_proses, selesai)
            if (isset($data['status'])) {
                $assignment->update(['status' => $data['status']]);
            }

            // Record history
            $this->letterService->recordHistory(
                $assignment->incoming_letter_id,
                $userId,
                'assignment_responded',
                'Tanggapan diberikan untuk disposisi/tugas: ' . $assignment->title,
                AssignmentResponse::class,
                $response->id
            );

            return $response;
        });
    }
}