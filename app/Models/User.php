<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'settings'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isProfessor()
    {
        return $this->role === 'professor';
    }

    // Añade esta relación
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_user');
    }
        protected $casts = [
        'email_verified_at' => 'datetime',
        'settings' => 'array', // Agregar esta línea
    ];
}