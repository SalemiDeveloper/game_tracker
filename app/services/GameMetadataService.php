<?php
// Arquivo responsável pela integração com a API escolhida.

namespace App\Services;

class GameMetadataService {
    private string $baseUrl;
    private string $apiKey;
    
    public function __construct() {
        $config = require __DIR__ . '/../../config/services.php';

        $this->baseUrl = $config['rawg']['base_url'];
        $this->apiKey  = $config['rawg']['api_key'];
    }

    private function request(string $endpoint, array $params = []): array {
        $params['key'] = $this->apiKey;

        $url = $this->baseUrl
            . $endpoint
            . '?'
            . http_build_query($params);

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($curl);

        curl_close($curl);
        $response = curl_exec($curl);

        return json_decode($response, true);
    }

    public function findByTitle(string $title): array {
        $data = $this->request('/games', [
            'search' => $title
        ]);

    return $this->mapGame($data);
    }

    public function mapGame(array $data): array {
        $game = $data['results'][0] ?? null;

        if (!$game) {
            return [];
        }

        return [
            'external_id' => $game['id'],
            'title'       => $game['name'],
            'cover'       => $game['background_image'],
            'released'    => $game['released'],
            'rating'      => $game['rating'],
            // 'platforms'   => $platforms,
            // 'genres'      => $genres
            'platforms' => $this->mapPlatforms($game['platforms'] ?? []),
            'genres'    => $this->mapGenres($game['genres'] ?? [])
        ];
    }

    private function mapPlatforms(array $platforms): array {
        $map = [
            'Xbox Series S/X' => 'Xbox Series X/S',
            'Android' => 'Mobile',
            'iOS' => 'Mobile',
        ];

        $result = [];

        foreach ($platforms as $item) {
            $name = $item['platform']['name'] ?? null;

            if (!$name) {
                continue;
            }

            $result[] = $map[$name] ?? $name;
        }

        return array_values(array_unique($result));
    }

    private function mapGenres(array $genres): array {
        $map = [
            'Action' => 'Ação',
            'Adventure' => 'Aventura',
            'RPG' => 'RPG',
            'Strategy' => 'Estratégia',
            'Puzzle' => 'Puzzle',
            'Racing' => 'Corrida',
            'Sports' => 'Esporte',
            'Fighting' => 'Luta',
            'Simulation' => 'Simulação',
            'Shooter' => 'FPS',
        ];

        $result = [];

        foreach ($genres as $genre) {
            $name = $genre['name'] ?? null;

            if (!$name) {
                continue;
            }

            if (isset($map[$name])) {
                $result[] = $map[$name];
            }
        }

        return array_values(array_unique($result));
    }
}