<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDocument extends Model
{
    protected $fillable = [
        'project_id',
        'tipe_data',
        'file_path',
        'deskripsi'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}