<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Events\OrderStatusChanged;
use App\Notifications\SellerCourierNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_receives_notification_when_order_status_changes()
    {
        Notification::fake();

        $seller = User::factory()->create(['role' => 'seller']);
        $customer = User::factory()->create(['role' => 'customer']);

        $order = Order::factory()->create([
            'seller_id' => $seller->id,
            'customer_id' => $customer->id,
            'status' => 'pending'
        ]);

        event(new OrderStatusChanged($order, 'pending', 'processing'));

        Notification::assertSentTo(
            $seller,
            SellerCourierNotification::class,
            function ($notification) use ($order) {
                return $notification->orderDetails['id'] === $order->id;
            }
        );
    }

    public function test_courier_receives_notification_when_assigned_to_order()
    {
        Notification::fake();

        $seller = User::factory()->create(['role' => 'seller']);
        $customer = User::factory()->create(['role' => 'customer']);
        $courier = User::factory()->create(['role' => 'courier']);

        $order = Order::factory()->create([
            'seller_id' => $seller->id,
            'customer_id' => $customer->id,
            'courier_id' => $courier->id,
            'status' => 'ready_for_delivery'
        ]);

        event(new OrderStatusChanged($order, 'processing', 'ready_for_delivery'));

        Notification::assertSentTo(
            $courier,
            SellerCourierNotification::class,
            function ($notification) use ($order) {
                return $notification->orderDetails['id'] === $order->id;
            }
        );
    }
}
