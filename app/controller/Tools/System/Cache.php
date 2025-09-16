<?php

namespace TOOL\System;

use Throwable;

class Cache
{

    /**
     * CACHE_DIR
     * 
     * @var string
     */
    private const CACHE_DIR = BASESTORAGE . '/cache';


    /**
     * Generate method
     * 
     * @param array $data
     * 
     * @return string
     */
    static function generate(array $data = [])
    {

        // Try find avaliable token
        do {

            $token = hash('sha256', random_bytes(16));
        } while (file_exists(self::CACHE_DIR . "/" . $token));


        // Save cache
        JSON::create(self::CACHE_DIR . "/" . $token)->set($data)->save(true);

        return $token;
    }

    /**
     * Open method
     * 
     * @param string $token
     * 
     * @return JSON|false
     */
    static function open(string $token)
    {
        try {

            return JSON::open(self::CACHE_DIR . "/" . basename($token));
        } catch (Throwable $error) {

            unset($error);

            return false;
        }
    }


    /**
     * Destroy method
     * 
     * @param string $token
     */
    static function destroy(string $token)
    {

        // Define path
        $path = self::CACHE_DIR . "/" . basename($token);

        // Check if exists
        if (file_exists($path))
            JSON::delete($path);
    }

    /**
     * Clear method
     * 
     */
    static function clear()
    {
        Path::open(self::CACHE_DIR)->clear();
    }
}
