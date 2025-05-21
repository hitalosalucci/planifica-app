<?php

namespace App\Enums;

enum RoomStatusEnum: string
{
    case AVAILABLE = 'available';
    case UNAVAILABLE = 'unavailable';
    case MAINTENANCE = 'maintenance';
    case INACTIVE = 'inactive';
}