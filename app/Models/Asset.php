<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'category', 'name', 'material', 'brand', 'code',
        'qty', 'good', 'broken', 'pic', 'for_sale', 'obsolete',
    ];

    public function lendings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Lending::class);
    }
}
