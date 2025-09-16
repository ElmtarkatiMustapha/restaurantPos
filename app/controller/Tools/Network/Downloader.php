<?php

namespace TOOL\Network;

class Downloader
{

    /**
     * Download file method
     * 
     * @param string $file_url
     * 
     * @param string $save_to
     */
    static function downloadFile($file_url, $save_to)
    {
        $fp = fopen($save_to, 'w');

        $ch = curl_init($file_url);
        curl_setopt($ch, CURLOPT_FILE, $fp);

        curl_exec($ch);

        curl_close($ch);
        fclose($fp);
    }
}
