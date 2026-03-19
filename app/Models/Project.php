<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Project extends Model {
    protected $fillable = ['nama_proyek', 'deskripsi', 'lokasi', 'anggaran', 'tahun', 'status'];
    
    public function financials() { return $this->hasMany(FinancialReport::class); }
    public function documents() { return $this->hasMany(ProjectDocument::class); }
    public function votes() { return $this->hasMany(Vote::class); }
}