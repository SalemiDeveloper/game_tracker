<?php

namespace App\Helpers;

class StatusHelper {

    private static array $statusMap = [
        'backlog'    => 'Vou jogar',
        'jogando'      => 'Jogando',
        'zerado'        => 'Zerei',
        '100_porcento' => '100%',
        'platina'     => 'Platinado',
        'dropado'    => 'Dropado',
    ];

    public static function all(): array {
        return self::$statusMap;
    }

    public static function options(): array {
        return array_keys(self::$statusMap);
    }

    public static function format(string $status): string {
        return self::$statusMap[$status] ?? $status;
    }

    public static function requiresRating(string $status): bool {
        return in_array($status, [
            'zerado',
            'platinado'
        ]);
    }

    public static function formatRating(?float $rating): string {
        return $rating !== null ? (string) $rating : "N/A";
    }
}
?>