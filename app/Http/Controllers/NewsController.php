<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsRecipient;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $news = News::with('creator')->latest()->paginate(10);
        } else {
            // User can see 'semua', their 'bagian', or their 'individu'
            $news = News::where('target_type', 'semua')
                ->orWhereHas('recipients', function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->orWhere('department_id', $user->department_id);
                })
                ->where('status', 'published')
                ->latest()
                ->paginate(10);
        }

        return view('news.index', compact('news'));
    }

    public function create()
    {
        if (!auth()->user()->hasRole('admin')) abort(403);
        $departments = Department::all();
        $users = User::all();
        return view('news.create', compact('departments', 'users'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string',
            'target_type' => 'required|in:semua,bagian_tertentu,individu_tertentu',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['created_by'] = auth()->id();
        if ($validated['status'] == 'published') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public/news_images');
        }

        $news = News::create($validated);

        if ($validated['target_type'] == 'bagian_tertentu' && $request->has('departments')) {
            foreach ($request->departments as $deptId) {
                NewsRecipient::create(['news_id' => $news->id, 'department_id' => $deptId]);
            }
        } elseif ($validated['target_type'] == 'individu_tertentu' && $request->has('users')) {
            foreach ($request->users as $userId) {
                NewsRecipient::create(['news_id' => $news->id, 'user_id' => $userId]);
            }
        }

        return redirect()->route('news.index')->with('success', 'Berita berhasil dibuat.');
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        // For simplicity
    }
    public function update(Request $request, News $news)
    {
        // For simplicity
    }
    public function destroy(News $news)
    {
        if (!auth()->user()->hasRole('admin')) abort(403);
        $news->delete();
        return redirect()->route('news.index')->with('success', 'Berita dihapus.');
    }
}
