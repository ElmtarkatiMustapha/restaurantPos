<?php

namespace TOOL\System;

use Error;

class Path
{

    /**
     * Path
     * 
     * @var string
     */
    private string $path;

    /**
     * Use
     * 
     * @var ?array
     */
    private ?array $use = null;

    /**
     * Skip
     * 
     * @var ?array
     */
    private ?array $skip = null;


    /**
     * Path __construct
     * 
     * @param string $path
     */
    function __construct(string $path)
    {
        $this->path = self::checkDir($path);
    }


    /**
     * Check dir
     * 
     * @param string $dir
     * 
     * @return string
     */
    private static function checkDir(string $dir)
    {
        // Define readl dir
        $realDir = realpath($dir);

        // Check is dir
        if ($realDir && is_dir($realDir))
            return $realDir;

        throw new \Error("Not Found Directory {$dir}");
    }

    /**
     * Open method
     * 
     * @param string $path
     * 
     * @return self
     */
    static function open(string $path)
    {
        return new self($path);
    }

    /**
     * Go method
     * 
     * @param string $path
     * 
     * @return self
     */
    public function go(string $path)
    {

        // Set new path
        $this->path = self::checkDir("{$this->path}/{$path}");

        // Return use and skip as null
        $this->use = null;
        $this->skip = null;

        return $this;
    }

    /**
     * Skip method
     * 
     * @param array $paths
     * 
     * @return self
     */
    public function skip(array $paths)
    {

        $this->skip = array_map(function ($path) {
            return realpath("{$this->path}/{$path}");
        }, $paths);

        return $this;
    }

    /**
     * Use method
     * 
     * @param array $paths
     * 
     * @return self
     */
    public function use(array $paths)
    {

        $this->use = array_map(function ($path) {
            return realpath("{$this->path}/{$path}");
        }, $paths);

        return $this;
    }

    /**
     * Make method
     * 
     * @param string $dirname
     * 
     * @return
     */
    public function make(string $dirname)
    {

        if (!is_dir("{$this->path}/{$dirname}"))
            mkdir("{$this->path}/{$dirname}", 0777, true);

        return $this->go($dirname);
    }

    /**
     * Create files method
     * 
     * @param array $files
     * 
     * @return self
     */
    public function createFiles(array $files)
    {

        foreach ($files as $file) {

            if (!file_exists("{$this->path}/$file"))
                file_put_contents("{$this->path}/$file", null);
        }
    }

    /**
     * Clear method
     * 
     * @param ?string $path
     */
    public function clear(?string $path = null)
    {
        if (!$path) $path = $this->path;

        foreach (glob($path . '/{,.}[!.,!..]*', GLOB_MARK | GLOB_BRACE) as $subPath) {

            if (
                ($this->skip && in_array(realpath($subPath), $this->skip))
                ||
                ($this->use && !in_array(realpath($subPath), $this->use))
            )
                continue;

            if (is_file($subPath))
                unlink($subPath);

            else if (is_dir($subPath)) {
                $this->clear($subPath);
                @rmdir($subPath);
            }
        }
    }

    /**
     * Copy method
     * 
     * @param string $to
     * 
     * @param ?string $from
     */
    public function copy(string $to, ?string $from = null)
    {
        // Check to dir
        $to = self::checkDir($to);

        // Define from
        if (!$from) $from = $this->path;

        foreach (scandir($from) as $file) {

            $subFrom = "{$from}/{$file}";
            $subTo = "{$to}/{$file}";

            if (
                ($this->skip && in_array(realpath($subFrom), $this->skip))
                ||
                ($this->use && !in_array(realpath($subFrom), $this->use))
            )
                continue;

            if (is_dir($subFrom) && !in_array($file, ['.', '..'])) {

                mkdir($subTo);
                self::copy($subTo, $subFrom);
            } else if (is_file($subFrom)) {

                @copy($subFrom, $subTo);
            }
        }
    }

    /**
     * Delete method
     * 
     */
    public function delete()
    {
        $this->clear();

        @rmdir($this->path);
    }

    /**
     * Move method
     * 
     * @param string $to
     */
    public function move(string $to)
    {
        $this->copy($to);
        $this->delete();
    }

    /**
     * To zip method
     * 
     * @param string $path
     * 
     * @param \ZipArchive $zip
     * 
     * @param ?string $base
     */
    private function toZip(string $path, \ZipArchive $zip, ?string $base = null)
    {

        foreach (scandir($path) as $file) {

            $from = realpath("{$path}/{$file}");
            $relativePath = $base ? "{$base}/{$file}" : $file;

            if (
                ($this->skip && in_array($from, $this->skip))
                ||
                ($this->use && !in_array($from, $this->use))
            )
                continue;

            if (is_dir($from) && !in_array($file, ['.', '..'])) {

                $zip->addEmptyDir($relativePath);
                $this->toZip($from, $zip, $relativePath);
            } else if (is_file($from)) {

                $zip->addFile($from, $relativePath);
            }
        }
    }

    /**
     * Zip method
     * 
     * @param string $name
     * 
     * @param ?string $saveTo
     */
    public function zip(string $name, ?string $saveTo = null)
    {

        // Define to
        $saveTo = $saveTo ? self::checkDir($saveTo) : $this->path;

        // Initialize archive object
        $zip = new \ZipArchive();
        $zip->open("{$saveTo}/{$name}.zip", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        // To zip
        $this->toZip($this->path, $zip);

        // Close
        $zip->close();
    }

    /**
     * Unzip
     * 
     * @param string $archive
     */
    public function unzip(string $archive)
    {

        // Check is readable
        if (!is_readable($archive))
            throw new Error("Not Found {$archive} archive");

        $zip = new \ZipArchive;

        if ($zip->open($archive) === TRUE) {
            $zip->extractTo($this->path);
            $zip->close();
        } else
            throw new Error("Error in archive {$archive}");
    }

    /**
     * Command method
     * 
     * @param string $command
     * 
     * @param bool $print
     * 
     * @return self
     */
    public function command(string $command)
    {

        $command = Command::run($command, $this->path);

        return $this;
    }

    /**
     * Do method
     * 
     * @param callable $action
     * 
     * @return self
     */
    public function do(callable $action)
    {
        $action($this->path);

        return $this;
    }

    /**
     * Back method
     * 
     * @param int $times
     * 
     * @return self
     */
    public function back(int $times = 1)
    {

        $this->path = self::checkDir(dirname($this->path, $times));

        return $this;
    }

    /**
     * Is zip method
     * 
     * @param string $archive
     * 
     * @return bool
     */
    static function isZip(string $archive)
    {
        $zip = new \ZipArchive;

        if ($zip->open($archive) === TRUE)
            return true;

        return false;
    }
}
