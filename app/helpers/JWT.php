<?php

namespace App\Helpers;

class JWT {

    // Temporariamente usar isso, depois mudar para .env
    private static $secret = 'EM_TESTE_123';

    public static function generate($payload) {

        $payload['iat'] = $payload['iat'] ?? time();
        $payload['exp'] = $payload['iat'] ?? time() + (60 * 15);
        //$payload['exp'] = time() + 20;

        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256'
        ]);

        $payload = json_encode($payload);

        $base64Header  = self::base64URLEncode($header);
        $base64Payload = self::base64URLEncode($payload);

        $signature = hash_hmac(
            'sha256',
            $base64Header . "." . $base64Payload,
            self::$secret,
            true
        );

        $base64Signature = self::base64UrlEncode($signature);

        return $base64Header. "." .$base64Payload. "." .$base64Signature;
    }

    public static function validate($jwt) {
        
        $parts = explode(".", $jwt);

        if (count($parts) !== 3) {
            return false;
        }

        [$header, $payload, $signature] = $parts;

        $validSignature = self::base64URLEncode(
            hash_hmac(
                'sha256',
                $header.".".$payload,
                self::$secret,
                true
            )
        );

        if ($signature !== $validSignature) {
            return false;
        }

        $decodedPayload = json_decode(
            base64_decode($payload),
            true
        );

        if (isset($decodedPayload['exp']) && time() > $decodedPayload['exp']) {
            return false;
        }

        return $decodedPayload;
    }

    private static function base64UrlEncode($data) {

        return rtrim(
            strtr(base64_encode($data), '+/', '-_'),
            '='
        );
    }
}

?>