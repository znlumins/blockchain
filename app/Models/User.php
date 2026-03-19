<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable {
    protected $fillable = ['name', 'username', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];
    
    public function votes() { return $this->hasMany(Vote::class); }
}