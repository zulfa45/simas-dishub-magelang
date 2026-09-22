<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\IncomingLetter;
use App\Models\Department;
use App\Models\User;
use App\Services\AssignmentService;

class AssignmentController extends Controller
{
    protected $assignmentService;

    public function __construct(AssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    public function create(IncomingLetter $letter)
    {
        // Hanya admin yang bisa mendisposisikan surat secara umum
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $departments = Department::all();
        $users = User::role(['staf-loket', 'karyawan'])->get();

        return view('assignments.create', compact('letter', 'departments', 'users'));
    }

    public function store(Request $request, IncomingLetter $letter)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'instruction' => 'required|string',
            'recipient_type' => 'required|in:individu,bagian,semua_karyawan',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:rendah,normal,tinggi,urgent',
            'recipients' => 'required_unless:recipient_type,semua_karyawan|array',
        ]);

        $recipientsData = [];
        if ($validated['recipient_type'] === 'individu') {
            foreach ($request->recipients as $userId) {
                $recipientsData[] = ['user_id' => $userId];
            }
        } elseif ($validated['recipient_type'] === 'bagian') {
            foreach ($request->recipients as $deptId) {
                $recipientsData[] = ['department_id' => $deptId];
            }
        } else {
            // Semua karyawan
            $allUsers = User::role('karyawan')->pluck('id');
            foreach ($allUsers as $userId) {
                $recipientsData[] = ['user_id' => $userId];
            }
        }

        $this->assignmentService->createAssignment($letter, $validated, $recipientsData, auth()->id());

        return redirect()->route('incoming-letters.show', $letter->id)->with('success', 'Disposisi berhasil dibuat dan dikirimkan.');
    }
}
