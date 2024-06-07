<?php

namespace App\Helper;

use Firebase\JWT\Key;

class JWTHelper
{
    public static $KEY = 'ijiuxocijwlkejlkjzxlkcjoijoi23#$$@fasdf';
    public static $ALG = 'HS256';

    public static function encode($value, $ttl = 31536000)
    {
        $payload = [
            'iss' => self::$KEY,
            'aud' => $value,
            'iat' => time(),
            'exp' => time() + $ttl
        ];
        return \Firebase\JWT\JWT::encode($payload, self::$KEY, self::$ALG);
    }

    public static function decode($toke, $dataKey = 'aud')
    {
        try {
            $data = \Firebase\JWT\JWT::decode($toke, new Key(self::$KEY, self::$ALG));
            $data = json_decode(json_encode($data), true);
        } catch (\Exception $exception) {
            return [];
        }
        return $data[$dataKey];
    }
}