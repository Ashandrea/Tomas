<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Review extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'order_id',
        'food_id',
        'customer_id',
        'seller_id',
        'courier_id',
        'courier_rating',
        'courier_comment'
    ];

    protected $casts = [
        'courier_rating' => 'integer'
    ];

    // Relationships
    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function foodRatings()
    {
        return $this->hasMany(FoodRating::class);
    }

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    // Validation methods
    public static function validateRatings(array $data): bool
    {
        // Validate food ratings
        if (isset($data['food_ratings']) && is_array($data['food_ratings'])) {
            foreach ($data['food_ratings'] as $foodId => $rating) {
                if (!isset($rating['rating']) || $rating['rating'] < 1 || $rating['rating'] > 5) {
                    return false;
                }
            }
        }
        
        // Validate courier rating
        $courierRatingValid = !isset($data['courier_rating']) || 
            ($data['courier_rating'] >= 1 && $data['courier_rating'] <= 5);

        return $courierRatingValid;
    }
}
