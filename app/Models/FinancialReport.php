<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialReport extends Model
{
    // DAFTAR KOLOM YANG BOLEH DIISI (WAJIB ADA)
    protected $fillable = [
        'project_id',
        'jenis',
        'uraian',
        'volume',
        'satuan',
        'harga_satuan',
        'jumlah'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}