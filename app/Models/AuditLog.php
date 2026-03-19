<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AuditLog extends Model {
    protected $fillable = ['action', 'model_type', 'model_id', 'data', 'previous_hash', 'hash', 'created_by'];
    protected $casts = ['data' => 'array'];
}