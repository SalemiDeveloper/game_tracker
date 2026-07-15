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

    private function request(string $endpoint, array $params = []): array
{
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

        $platforms = [];
        foreach($game['platforms'] as $platform) {
            $platforms[] = $platform['platform']['name'];
        }

        $genres = [];
        foreach($game['genres'] as $genre) {
            $genres[] = $genre['name'];
        }

        return [
            'external_id' => $game['id'],
            'title'       => $game['name'],
            'cover'       => $game['background_image'],
            'released'    => $game['released'],
            'rating'      => $game['rating'],
            'platforms'   => $platforms,
            'genres'      => $genres
        ];
    }
}