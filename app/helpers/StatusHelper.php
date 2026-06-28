<?php

namespace App\Helpers;

class StatusHelper {

    private static array $statusMap = [
        'vou_jogar'    => 'Vou jogar',
        'jogando'      => 'Jogando',
        'zerei'        => 'Zerei',
        '100_porcento' => '100%',
        'platinei'     => 'Platinado',
        'abandonei'    => 'Abandonado',
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
}
?>