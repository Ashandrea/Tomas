<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Order extends Model
{
    use HasFactory, HasUuids;

    // Order status constants
    public const STATUS_PENDING = 'pending';
    public const STATUS_COURIER_ASSIGNED = 'courier_assigned';
    public const STATUS_COURIER_PICKED = 'courier_picked';
    public const STATUS_PREPARING = 'preparing';
    public const STATUS_ON_DELIVERY = 'on_delivery';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'id',
        'customer_id',
        'seller_id',
        'courier_id',
        'status',
        'delivery_location',
        'notes',
        'total_amount',
        'estimated_delivery_time',
        'actual_delivery_time',
        'cancellation_reason',
        'cancelled_at',
        'courier_assigned_at',
        'food_picked_at'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'estimated_delivery_time' => 'datetime',
        'actual_delivery_time' => 'datetime',
        'cancelled_at' => 'datetime',
        'courier_assigned_at' => 'datetime',
        'food_picked_at' => 'datetime',
        'delivery_location' => 'string'
    ];

    // Relationships
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

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'order_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'order_id');
    }

    // Scopes
    public function scopePending(Builder $query): void
    {
        $query->where('status', self::STATUS_PENDING);
    }

    public function scopeActive(Builder $query): void
    {
        $query->whereNotIn('status', [self::STATUS_DELIVERED, self::STATUS_CANCELLED]);
    }

    public function scopeReady(Builder $query): void
    {
        $query->where('status', 'ready')
            ->whereNull('courier_id');
    }

    // Status management
    public function updateStatus(string $status): void
    {
        $validStatuses = [
            self::STATUS_PENDING,
            self::STATUS_COURIER_ASSIGNED,
            self::STATUS_COURIER_PICKED,
            self::STATUS_PREPARING,
            self::STATUS_ON_DELIVERY,
            self::STATUS_DELIVERED,
            self::STATUS_CANCELLED
        ];

        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException('Invalid order status');
        }

        // Status transition validation
        $allowedTransitions = [
            self::STATUS_PENDING => [self::STATUS_COURIER_ASSIGNED, self::STATUS_CANCELLED],
            self::STATUS_COURIER_ASSIGNED => [self::STATUS_COURIER_PICKED, self::STATUS_CANCELLED],
            self::STATUS_COURIER_PICKED => [self::STATUS_PREPARING, self::STATUS_CANCELLED],
            self::STATUS_PREPARING => [self::STATUS_ON_DELIVERY, self::STATUS_CANCELLED],
            self::STATUS_ON_DELIVERY => [self::STATUS_DELIVERED, self::STATUS_CANCELLED],
            self::STATUS_DELIVERED => [],
            self::STATUS_CANCELLED => []
        ];

        if (!in_array($status, $allowedTransitions[$this->status] ?? [])) {
            throw new \InvalidArgumentException('Invalid status transition');
        }

        DB::transaction(function () use ($status) {
            $this->status = $status;
            
            switch ($status) {
                case self::STATUS_COURIER_ASSIGNED:
                    $this->courier_assigned_at = now();
                    break;
                case self::STATUS_COURIER_PICKED:
                    $this->food_picked_at = now();
                    break;
                case self::STATUS_DELIVERED:
                    $this->actual_delivery_time = now();
                    break;
                case self::STATUS_CANCELLED:
                    $this->cancelled_at = now();
                    break;
            }

            $this->save();

            // Update courier status if needed
            if ($this->courier_id) {
                $courier = $this->courier;
                if ($status === self::STATUS_DELIVERED || $status === self::STATUS_CANCELLED) {
                    $courier->updateCourierStatus(User::COURIER_STATUS_AVAILABLE);
                } elseif (in_array($status, [self::STATUS_COURIER_ASSIGNED, self::STATUS_COURIER_PICKED, self::STATUS_ON_DELIVERY])) {
                    $courier->updateCourierStatus(User::COURIER_STATUS_BUSY);
                }
            }
        });
    }

    // Courier assignment
    public static function assignCourier(Order $order): ?User
    {
        return DB::transaction(function () use ($order) {
            $availableCourier = User::query()
                ->where('role', User::ROLE_COURIER)
                ->where('is_active', true)
                ->where('courier_status', User::COURIER_STATUS_AVAILABLE)
                ->inRandomOrder()
                ->first();

            if ($availableCourier) {
                $order->courier_id = $availableCourier->id;
                $order->updateStatus(self::STATUS_COURIER_ASSIGNED);
                return $availableCourier;
            }

            return null;
        });
    }

    // Helper methods
    public function canBeCancelled(): bool
    {
        return !in_array($this->status, [self::STATUS_DELIVERED, self::STATUS_CANCELLED]);
    }

    public function hasReview(): bool
    {
        return $this->review()->exists();
    }

    public function canBeReviewed(): bool
    {
        return $this->status === self::STATUS_DELIVERED && !$this->hasReview();
    }
}