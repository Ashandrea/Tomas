<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasUuids;
    
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['user_id', 'food_id'];
    
    /**
     * Get the user that owns the like.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the food that was liked.
     */
    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}
