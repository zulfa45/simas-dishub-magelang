<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $query = AuditLog::with('user')->latest();

        if ($request->has('action_type') && $request->action_type != '') {
            $query->where('action', $request->action_type);
        }

        if ($request->has('model_type') && $request->model_type != '') {
            $query->where('model_type', 'like', '%' . $request->model_type . '%');
        }

        $logs = $query->paginate(20)->withQueryString();

        return view('audit_logs.index', compact('logs'));
    }
}
