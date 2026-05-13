<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HandoverSignature extends Model
{
    protected $fillable = [
        'handover_id', 'role', 'signer_name', 'signer_email',
        'token', 'signature_data', 'signed_at', 'signed_ip',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
    ];

    public static array $roleLabels = [
        'dept_it'   => 'Departemen IT',
        'dept_head' => 'Departemen Head',
        'hrd'       => 'HRD - Personalia',
        'penerima'  => 'Penerima',
    ];

    public function handover(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Handover::class);
    }

    public function isSigned(): bool
    {
        return $this->signed_at !== null;
    }
}
