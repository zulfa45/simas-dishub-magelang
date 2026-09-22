<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomingLetter;
use App\Models\LetterCategory;
use App\Services\LetterService;

class IncomingLetterController extends Controller
{
    protected $letterService;

    public function __construct(LetterService $letterService)
    {
        $this->letterService = $letterService;
    }

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_agenda' => 'required|string|max:255|unique:incoming_letters',
            'nomor_surat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:letter_categories,id',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string',
            'instansi_pengirim' => 'required|string|max:255',
            'asal_surat' => 'required|string|max:255',
            'sifat' => 'required|in:biasa,penting,rahasia,sangat_rahasia',
            'prioritas' => 'required|in:rendah,normal,tinggi,urgent',
            'ringkasan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB max
        ]);

        // Tanggal diterima otomatis diisi hari ini jika tidak dikirim dari form
        $validated['tanggal_diterima'] = now()->toDateString();
        
        // Memisahkan data lampiran agar tidak error saat create() model
        $lampiran = $request->file('lampiran');
        unset($validated['lampiran']);

        // Gunakan Service untuk memastikan transaksi aman
        $letter = $this->letterService->createLetter($validated, auth()->id());

        // Jika ada file lampiran, proses unggah
        if ($lampiran) {
            $this->letterService->uploadAttachment($letter, $lampiran, auth()->id());
        }

        return redirect()->route('incoming-letters.index')->with('success', 'Surat Masuk berhasil ditambahkan.');
    }

    public function show(IncomingLetter $incomingLetter)
    {
        $incomingLetter->load(['category', 'creator', 'attachments', 'histories.user']);
        return view('incoming_letters.show', compact('incomingLetter'));
    }
}
