<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workshop extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'foto',
        'capacity',
        'harga'
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
