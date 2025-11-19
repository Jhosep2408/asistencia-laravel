<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Especificar que la clave primaria es 'dni'
    protected $primaryKey = 'dni';
    
    // Indicar que la clave primaria no es auto-incremental
    public $incrementing = false;
    
    // Especificar el tipo de la clave primaria
    protected $keyType = 'string';

    protected $fillable = [
        'dni', 'first_name', 'last_name', 'guardian_phone', 
        'grade_id', 'classroom_id', 'shift', 'photo', 'barcode'
    ];
        protected $casts = [
        'shift' => 'string'
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_dni', 'dni');
    }

    // Asegúrate de tener este accessor
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
     // Nuevo accesor para el turno en español
    public function getShiftNameAttribute()
    {
        return $this->shift === 'morning' ? 'Mañana' : 'Tarde';
    }

    // Scope para filtrar por turno
    public function scopeByShift($query, $shift)
    {
        if ($shift) {
            return $query->where('shift', $shift);
        }
        return $query;
    }
}