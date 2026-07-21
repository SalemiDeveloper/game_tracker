<?php

namespace App\Helpers;

class PlatformHelper {
    public static function options(): array {
        return [
            'PC',
            'PlayStation 5',
            'PlayStation 4',
            'PlayStation 3',
            'Xbox Series X/S',
            'Xbox One',
            'Xbox 360',
            'Nintendo Switch',
            'Nintendo Switch 2',
            'Steam Deck',
            'Mobile'
        ];
    }
}