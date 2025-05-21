<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Like;

class Food extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'foods';

    protected $fillable = [
        'id',
        'seller_id',
        'name',
        'description',
        'price',
        'image',
        'is_available',
        'show_in_other_menu',
        'delivery_count',
    ];

    protected $attributes = [
        'delivery_count' => 0,
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'show_in_other_menu' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'food_id', 'order_id')
            ->withPivot(['quantity', 'price_at_time as price', 'notes'])
            ->withTimestamps();
    }
    
    /**
     * Get the likes for the food.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    /**
     * Get the users who liked this food.
     */
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes', 'food_id', 'user_id')
            ->withTimestamps();
    }
    
    /**
     * Check if the food is liked by the current user.
     */
    public function isLikedByUser($userId = null)
    {
        if (is_null($userId)) {
            $userId = auth()->id();
        }
        
        if (is_null($userId)) {
            return false;
        }
        
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Check if the image exists in storage
            if (Storage::disk('public')->exists($this->image)) {
                return Storage::disk('public')->url($this->image);
            }
            // If the image path is a full URL, return it as is
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
        }

        // Generate a random background color for the placeholder
        $colors = [
            '1abc9c', '2ecc71', '3498db', '9b59b6', 'f1c40f',
            'e67e22', 'e74c3c', '16a085', '27ae60', '2980b9',
            '8e44ad', 'f39c12', 'd35400', 'c0392b'
        ];
        $background = $colors[crc32($this->name) % count($colors)];
        
        // Get the first letter of each word for the placeholder
        $words = explode(' ', $this->name);
        $initials = '';
        $count = 0;
        foreach ($words as $word) {
            if ($count >= 2) break; // Limit to 2 initials
            if (strlen($word) > 0) {
                $initials .= strtoupper($word[0]);
        }
            if (strlen($initials) >= 2) break;
        }
        
        // If we only got one letter, use the first two letters of the first word
        if (strlen($initials) === 1 && strlen($words[0]) > 1) {
            $initials .= strtoupper($words[0][1]);
        }

        // Generate the placeholder URL
        return "https://ui-avatars.com/api/?" . http_build_query([
            'name' => $initials,
            'background' => $background,
            'color' => 'fff',
            'size' => 200,
            'bold' => true,
            'format' => 'svg'
        ]);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'food_id');
    }

    public function ratings()
    {
        return $this->hasMany(FoodRating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }
} 