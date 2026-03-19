<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'nama_proyek',
        'deskripsi',
        'lokasi',
        'anggaran',
        'tahun',
        'status'
    ];

    public function financials(): HasMany
    {
        return $this->hasMany(FinancialReport::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProjectDocument::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}