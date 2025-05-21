<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Showcase extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'student_id',
        'title',
        'description',
        'image',
        'is_active'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
} 