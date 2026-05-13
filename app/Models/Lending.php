<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    protected $fillable = [
        'asset_id', 'borrower', 'department',
        'lend_date', 'due_date', 'return_date', 'notes', 'status',
    ];

    protected $casts = [
        'lend_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    public function asset(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
