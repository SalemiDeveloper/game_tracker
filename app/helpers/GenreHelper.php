<?php

namespace App\Helpers;

class GenreHelper {
    public static function options(): array {
        return [
            'Ação',
            'Aventura',
            'RPG',
            'JRPG',
            'FPS',
            'TPS',
            'Estratégia',
            'Puzzle',
            'Corrida',
            'Esporte',
            'Luta',
            'Terror',
            'Roguelike',
            'Soulslike',
            'Simulação',
            'Visual Novel',
            'Metroidvania'
        ];
    }
}