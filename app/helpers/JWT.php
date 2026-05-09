<?php

class JWT {

    private static $secret = 'SUA_CHAVE_SECRETA';

    public static function generate($payload) {

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

        return json_decode(
            base64_decode($payload),
            true
        );
    }

    private static function base64UrlEncode($data) {

        return rtrim(
            strtr(base64_encode($data), '+/', '-_'),
            '='
        );
    }
}

?>