<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Services\AssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyTaskController extends Controller
{
    protected $assignmentService;

    public function __construct(AssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    public function index()
    {
        $user = Auth::user();

        // Get assignments where user is a direct recipient or part of a recipient department
        $tasks = Assignment::whereHas('recipients', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('department_id', $user->department_id);
        })->with('letter')
          ->latest()
          ->paginate(10);

        return view('my_tasks.index', compact('tasks'));
    }

    public function show(Assignment $assignment)
    {
        // Mark as read if not yet read by this user
        $recipient = $assignment->recipients()
            ->where(function($query) {
                $query->where('user_id', auth()->id())
                      ->orWhere('department_id', auth()->user()->department_id);
            })->first();

        if ($recipient && !$recipient->read_at) {
            $recipient->update(['read_at' => now()]);
            // Also update assignment status if it was unread
            if ($assignment->status === 'belum_dibaca') {
                $assignment->update(['status' => 'dibaca']);
            }
        }

        $assignment->load(['letter', 'responses.user']);

        return view('my_tasks.show', compact('assignment'));
    }

    public function respond(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'isi_tanggapan' => 'required|string',
            'status' => 'required|in:dalam_proses,selesai',
            'lampiran_file' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        ]);

        $data = [
            'isi_tanggapan' => $validated['isi_tanggapan'],
            'status' => $validated['status'],
        ];

        if ($request->hasFile('lampiran_file')) {
            $path = $request->file('lampiran_file')->store('private/assignment_responses');
            $data['lampiran'] = $path;
        }

        $this->assignmentService->submitResponse($assignment, $data, auth()->id());

        return redirect()->route('my-tasks.show', $assignment->id)->with('success', 'Tanggapan berhasil dikirim.');
    }
}
