<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Food;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasUuids, Notifiable;

    // Role constants
    public const ROLE_ADMIN = 'admin';
    public const ROLE_CUSTOMER = 'customer';
    public const ROLE_SELLER = 'seller';
    public const ROLE_COURIER = 'courier';
    public const ROLE_MAHASISWA = 'mahasiswa';

    // Courier status constants
    public const COURIER_STATUS_OFFLINE = 'offline';
    public const COURIER_STATUS_AVAILABLE = 'available';
    public const COURIER_STATUS_BUSY = 'busy';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'nim',
        'role',
        'profile_photo',
        'cover_photo',
        'is_active',
        'password',
        'courier_status',
        'last_active_at',
        'current_location',
        'language',
        'theme',
        'notification_preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_active_at' => 'datetime',
        'current_location' => 'array',
        'notification_preferences' => 'array',
    ];

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return Storage::url($this->profile_photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the URL to the user's cover photo.
     *
     * @return string
     */
    public function getCoverPhotoUrlAttribute()
    {
        if ($this->cover_photo) {
            return Storage::url($this->cover_photo);
        }
        return null;
    }

    // Relationships
    public function foods()
    {
        return $this->hasMany(Food::class, 'seller_id');
    }

    public function products()
    {
        return $this->hasMany(Food::class, 'seller_id');
    }
    
    /**
     * Get the user's liked foods.
     */
    public function likedFoods()
    {
        return $this->belongsToMany(Food::class, 'likes', 'user_id', 'food_id')
            ->withTimestamps();
    }

    public function customerOrders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function sellerOrders()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    public function courierOrders()
    {
        return $this->hasMany(Order::class, 'courier_id');
    }

    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    public function receivedFoodReviews()
    {
        return $this->hasMany(Review::class, 'seller_id');
    }

    public function receivedDeliveryReviews()
    {
        return $this->hasMany(Review::class, 'courier_id');
    }

    // General reviews method
    public function reviews()
    {
        if ($this->isCustomer()) {
            return $this->givenReviews();
        } elseif ($this->isSeller()) {
            return $this->receivedFoodReviews();
        } elseif ($this->isCourier()) {
            return $this->receivedDeliveryReviews();
        }
        
        // For admin or undefined roles, return an empty relation
        return $this->hasMany(Review::class, 'customer_id')->whereRaw('1 = 0');
    }

    // Role checks
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    public function isSeller(): bool
    {
        return $this->role === self::ROLE_SELLER;
    }

    public function isCourier(): bool
    {
        return $this->role === self::ROLE_COURIER;
    }

    public function isMahasiswa(): bool
    {
        return $this->role === self::ROLE_MAHASISWA;
    }

    // Courier specific methods
    public function isAvailableForDelivery(): bool
    {
        return $this->isCourier() 
            && $this->is_active 
            && $this->courier_status === self::COURIER_STATUS_AVAILABLE;
    }

    public function updateCourierStatus(string $status): void
    {
        if (!in_array($status, [self::COURIER_STATUS_OFFLINE, self::COURIER_STATUS_AVAILABLE, self::COURIER_STATUS_BUSY])) {
            throw new \InvalidArgumentException('Invalid courier status');
        }
        
        $this->courier_status = $status;
        $this->last_active_at = now();
        $this->save();
    }
}
