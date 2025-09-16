<?php

namespace TOOL\System;

class Command
{

    /**
     * Run method
     * 
     * @param string $command
     * 
     * @param ?string $path
     * 
     * @param bool $realtime
     * 
     * @return string
     */
    static function run(string $command, ?string $path = null, bool $realtime = true)
    {
        // Check path
        if ($path)
            $command = "cd {$path} && {$command}";

        // Is real time
        if ($realtime) {

            $open = popen($command, 'r');
            while ($line = fgets($open, 2048)) {
                echo $line;
                flush();
            }
            pclose($open);
        } else exec($command);
    }
}
