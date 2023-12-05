<?php

namespace App\Enums;

interface Enum
{
    /**
     * Get all cases of this enumerator
     * 
     * @return array Array containing all cases
     */
    public static function cases(): array;

    /**
     * Return the user-friendly label of specified case
     * or the provided string if the case isn't available
     * on this enumerator
     * 
     * @param mixed $case The case value to retrieve label
     * @return string User-friendly case label
     */
    public static function label($case): string;
}
