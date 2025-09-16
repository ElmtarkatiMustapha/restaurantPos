<?php

namespace TOOL\Helper;

class Convert
{

    /**
     * Object method
     * 
     * @param array $array
     * 
     * @return object
     */
    public static function object(array $array)
    {

        return json_decode(json_encode(
            $array
        ), false);
    }

    /**
     * Array method
     * 
     * @param array $object
     * 
     * @return array
     */
    public static function array(object $object)
    {

        return json_decode(json_encode(
            $object
        ), true);
    }

    /**
     * Text method
     * 
     * @param $text
     * 
     * @param $text
     */
    public static function text($text, ?int $max = null)
    {

        // Required convert to string
        $text = (string) $text;

        // If it is greater than the maximum
        if ($max && $max < strlen($text))
            return mb_substr($text, 0, $max) . "...";


        return $text;
    }
    public static function textFixed($input, $length)
    {
        // Check if the string needs to be trimmed
        if (strlen($input) > $length) {
            // Return trimmed string with ellipsis
            return substr($input, 0, $length - 3) . "...";
        } else {
            // Return string padded with spaces
            return str_pad($input, $length, " ");
        }
    }

    /**
     * Price method
     * 
     * @param $price
     * 
     * @return string
     */
    static function price($price)
    {

        return number_format($price, 2) . " DH";
    }
}
