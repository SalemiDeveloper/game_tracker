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
}
?>