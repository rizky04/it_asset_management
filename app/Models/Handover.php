<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Handover extends Model
{
    protected $fillable = [
        'doc_number', 'type', 'handover_date',
        'from_name', 'from_position', 'from_department', 'dept_head', 'hrd_name',
        'to_name', 'to_position', 'to_department', 'to_address',
        'device_label', 'merek', 'type_device', 'serial_number',
        'processor', 'storage', 'ram', 'screen_size', 'os', 'office_sw',
        'software_list', 'accessories_list', 'notes',
        'status', 'returned_at', 'returned_by', 'return_notes',
    ];

    protected $casts = [
        'handover_date' => 'date',
        'returned_at' => 'datetime',
        'software_list' => 'array',
        'accessories_list' => 'array',
    ];

    public function isReturned(): bool
    {
        return $this->status === 'returned';
    }

    /** Field spesifikasi perangkat yang di-copy saat serah terima ulang */
    public static array $deviceFields = [
        'type', 'from_name', 'from_position', 'from_department', 'dept_head',
        'device_label', 'merek', 'type_device', 'serial_number',
        'processor', 'storage', 'ram', 'screen_size', 'os', 'office_sw',
        'software_list', 'accessories_list',
    ];

    public function signatures(): HasMany
    {
        return $this->hasMany(HandoverSignature::class);
    }

    public function signature(string $role): ?HandoverSignature
    {
        return $this->signatures->firstWhere('role', $role);
    }

    public function generateSignatures(): void
    {
        $roles = [
            'dept_it' => $this->from_name,
            'dept_head' => $this->dept_head ?? 'Departemen Head',
            'hrd' => $this->hrd_name ?? 'HCGA Legal',
            'penerima' => $this->to_name,
        ];

        foreach ($roles as $role => $name) {
            $this->signatures()->firstOrCreate(
                ['role' => $role],
                ['signer_name' => $name, 'token' => bin2hex(random_bytes(32))]
            );
        }
    }

    public function generateDocNumber(): string
    {
        $year = now()->year;
        $month = (int) now()->format('m');
        $roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][$month - 1];
        $count = static::whereYear('created_at', $year)->count() + 1;

        return sprintf('IT/%s/%s/%04d', $roman, $year, $count);
    }
}
