<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Customer = 'customer';
    case Seller = 'seller';
    case Courier = 'courier';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Customer => 'Customer',
            self::Seller => 'Seller',
            self::Courier => 'Courier',
        };
    }
}
