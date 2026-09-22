<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomingLetter extends Model
{
    /** @use HasFactory<\Database\Factories\IncomingLetterFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor_agenda',
        'nomor_surat',
        'tanggal_surat',
        'tanggal_diterima',
        'asal_surat',
        'instansi_pengirim',
        'perihal',
        'ringkasan_isi',
        'kategori_id',
        'sifat',
        'prioritas',
        'keterangan',
        'status',
        'created_by',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(LetterCategory::class, 'kategori_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
