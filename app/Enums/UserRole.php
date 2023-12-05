<?php

namespace App\Enums;

class UserRole implements Enum
{

    const ADMIN = "admin";
    const MANAGER = "manager";
    const OPERATIONAL = "operational";

    public static function cases(): array {
        return [
            static::ADMIN,
            static::MANAGER,
            static::OPERATIONAL,
        ];
    }

    public static function label($case): string {
        switch($case){
            case static::ADMIN:
                return __("Administrator");
            case static::MANAGER:
                return __("Manager");
            case static::OPERATIONAL:
                return __("Operational");
            default:
                return $case;
        }
    }
    
}