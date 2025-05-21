<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class FoodRating extends Model
{
    use HasUuids;

    protected $fillable = [
        'id',
        'food_id',
        'review_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
