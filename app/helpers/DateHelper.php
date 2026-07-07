<?php

namespace App\Helpers;

use DateTime;

class DateHelper {
    /**
     * Retorna uma data em formato humano.
     *
     * Exemplos:
     * Hoje
     * Ontem
     * Há 5 dias
     * Há 2 meses
     * Há 1 ano
     */
    public static function human(?string $date): string {
        if (empty($date)) {
            return '-';
        }

        $now = new DateTime();
        $target = new DateTime($date);

        $diff = $now->diff($target);

        if ($diff->y > 0) {
            return $diff->y === 1
                ? 'Há 1 ano'
                : "Há {$diff->y} anos";
        }

        if ($diff->m > 0) {
            return $diff->m === 1
                ? 'Há 1 mês'
                : "Há {$diff->m} meses";
        }

        if ($diff->d === 0) {
            return 'Hoje';
        }

        if ($diff->d === 1) {
            return 'Ontem';
        }

        return "Há {$diff->d} dias";
    }

    /**
     * Retorna a data no formato brasileiro.
     * Ex.: 07/07/2026
     */
    public static function date(?string $date): string {
        if (empty($date)) {
            return '-';
        }

        return (new DateTime($date))->format('d/m/Y');
    }

    /**
     * Retorna data e hora no formato brasileiro.
     * Ex.: 07/07/2026 14:30
     */
    public static function dateTime(?string $date): string {
        if (empty($date)) {
            return '-';
        }

        return (new DateTime($date))->format('d/m/Y H:i');
    }
}