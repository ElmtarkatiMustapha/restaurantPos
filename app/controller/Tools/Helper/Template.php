<?php

namespace TOOL\Helper;

class Template
{

    /**
     * BASE
     * 
     * @var string
     */
    const BASE = BASERESOURCES . '/template';


    /**
     * Get method
     * 
     * @param string $path
     * 
     * @param array $params don't use [path, content]
     * 
     * @return
     */
    static function get(string $path, array $params = [])
    {

        foreach ($params as $key => $value)
            ${$key} = $value;

        ob_start();
        include $path;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
