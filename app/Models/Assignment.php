<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'incoming_letter_id',
        'title',
        'instruction',
        'recipient_type',
        'deadline',
        'priority',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
        ];
    }

    public function letter(): BelongsTo
    {
        return $this->belongsTo(IncomingLetter::class, 'incoming_letter_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(AssignmentRecipient::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(AssignmentResponse::class);
    }
}
