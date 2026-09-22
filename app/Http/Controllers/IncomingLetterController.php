<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\IncomingLetter;
use App\Models\LetterCategory;

class IncomingLetterController extends Controller
{
    public function index()
    {
        $letters = IncomingLetter::with(['category', 'creator'])->latest()->paginate(10);
        return view('incoming_letters.index', compact('letters'));
    }

    public function create()
    {
        $categories = LetterCategory::all();
        return view('incoming_letters.create', compact('categories'));
    }
}
