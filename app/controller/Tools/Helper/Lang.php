<?php

namespace TOOL\Helper;

use TOOL\System\JSON;

class Lang
{

    /**
     * BASE
     * 
     * @var string
     */
    private const BASE = BASERESOURCES . '/langue';

    /**
     * Words
     * 
     * @var ?array
     */
    private static ?array $words = null;


    /**
     * Tran method
     * 
     * @param string $word
     * 
     * @return
     */
    static function tran(string $word)
    {

        // Check has not setup
        if (!self::$words)
            self::$words = (array) JSON::open(self::BASE . '/' . config('APP_LANG', 'fr') . '.json')->read();

        return self::$words[$word] ?? $word;
    }
}
