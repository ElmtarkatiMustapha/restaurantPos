<?php

namespace TOOL\Security;

use TOOL\System\Cache;

class Token
{


    /**
     * Generate method
     * 
     * @param array $data
     * 
     * @param ?string $lifetime
     * 
     * @return string
     */
    static function generate(array $data, ?string $lifetime = null)
    {
        // Safe lifetime calculation
        $timestamp = null;

        if ($lifetime !== null) {
            $timestamp = strtotime($lifetime);
            if ($timestamp === false) {
                $timestamp = null; // fallback if strtotime fails
            }
        }

        $data = [
            "lifetime" => $timestamp,
            "data" => $data
        ];

        return Cache::generate($data);
    }

    /**
     * Verify method
     * 
     * @param string $token
     * 
     * @return object|false
     */
    static function verify(string $token)
    {
        // If token not found
        if (!$cache = Cache::open($token))
            return false;

        return $cache->read()->data;
    }

    /**
     * Destroy method
     * 
     * @param string $token
     * 
     * @return
     */
    static function destroy(string $token)
    {
        Cache::destroy($token);
    }
}
