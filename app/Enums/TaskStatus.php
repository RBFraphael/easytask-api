<?php

namespace App\Enums;

class TaskStatus implements Enum
{

    const PLANNING = "planning";
    const PENDING = "pending";
    const WAITING = "waiting";
    const BLOCKED = "blocked";
    const ACTIVE = "active";
    const FINISHED = "finished";
    
    public static function cases(): array {
        return [
            static::PLANNING,
            static::PENDING,
            static::WAITING,
            static::BLOCKED,
            static::ACTIVE,
            static::FINISHED,
        ];
    }

    public static function label($case): string {
        switch($case){
            case static::PLANNING:
                return __("Planning");
            case static::PENDING:
                return __("Pending");
            case static::WAITING:
                return __("Waiting information");
            case static::BLOCKED:
                return __("Blocked");
            case static::ACTIVE:
                return __("Active");
            case static::FINISHED:
                return __("Finished");
            default:
                return $case;
        }
    }

    public static function color($case): string {
        
        /**
         * Color palette from https://flatuicolors.com/palette/defo
         */

        switch($case){
            case static::PLANNING:
                return "#8e44ad"; // Wisteria
            case static::PENDING:
                return "#2980b9"; // Belize Hole
            case static::WAITING:
                return "#f39c12"; // Orange
            case static::BLOCKED:
                return "#e74c3c"; // Alizarin
            case static::ACTIVE:
                return "#16a085"; // Green sea
            case static::FINISHED:
                return "#27ae60"; // Nephritis
            default:
                return "#000000"; // Black
        }
    }
    
}