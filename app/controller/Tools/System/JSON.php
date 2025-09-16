<?php

namespace TOOL\System;

use Error;
use TOOL\Helper\Convert;

class JSON
{

    /**
     * File path
     * 
     * @var string
     */
    private string $filepath;

    /**
     * Json
     * 
     * @var array
     */
    private array $json = [];

    /**
     * Map
     * 
     * @var array
     */
    private array $map = [];


    /**
     * JSON __construct
     * 
     * @param string $filepath
     */
    function __construct(string $filepath)
    {
        if (!is_readable($filepath))
            throw new \Error("File is not find or not readable");

        // Set file path
        $this->filepath = $filepath;

        // Define content
        $content = file_get_contents($this->filepath);

        // Export json data
        $this->json = json_decode(
            $content ? $content : '{}',
            true
        );
    }


    /**
     * Map method
     * 
     * @param string $route
     * 
     * @return array
     */
    private function map(string $route)
    {

        // Explode route
        $map = explode("/", $route);

        // Remove first slash if exists
        if ($route[0] === '/')
            array_shift($map);

        // Append route
        else
            $map = array_merge($this->map, $map);

        return $map;
    }

    /**
     * Generate method
     * 
     * @param ?array $params
     * 
     * @return array
     */
    private function generate(?array $params)
    {

        $newJson = $params;

        // Check map is exists
        foreach (array_reverse($this->map) as $child) {

            // Check child
            if ($child === '') continue;

            $newJson = [
                $child => $newJson
            ];
        }

        return (array) $newJson;
    }

    /**
     * Open method
     * 
     * @param string $filepath
     * 
     * @return self
     */
    static function open(string $filepath)
    {

        return new self($filepath);
    }

    /**
     * Create method
     * 
     * @param string $filepath
     * 
     * @param string $replace
     * 
     * @return self
     */
    static function create(string $filepath, bool $replace = false)
    {

        // Check file if exists
        if (file_exists($filepath) && !$replace)
            throw new Error("The file {$filepath} already exists");

        file_put_contents($filepath, "");

        return new self($filepath);
    }

    /**
     * Delete method
     * 
     * @param string $filepath
     */
    static function delete(string $filepath)
    {

        unlink($filepath);
    }

    /**
     * Go method
     * 
     * @param ?string $route
     * 
     * @return self
     */
    public function go(?string $route)
    {

        if ($route)
            $this->map = $this->map($route);

        return $this;
    }

    /**
     * Read method
     * 
     * @return
     */
    public function read()
    {

        $json = $this->json;

        // Check map is exists
        foreach ($this->map as $child) {

            // Check is array
            if (!is_array($json)) {

                $json = null;
                break;
            }

            // Check child
            if ($child === '') continue;

            $json = $json[$child];
        }

        return is_array($json) ? Convert::object($json) : $json;
    }

    /**
     * Set method
     * 
     * @param ?array $params
     * 
     * @param bool $append
     * 
     * @return
     */
    public function set(?array $params, bool $append = false)
    {

        // Check is append
        if ($append) {

            // Read old data
            $readOld = (array) $this->read();

            array_push($readOld, ...$params);

            // Update params
            $params = $readOld;
        }

        // Update json
        $this->json = (array) @array_replace_recursive(
            $this->json,
            $this->generate($params)
        );

        return $this;
    }

    /**
     * Clear method
     * 
     * @return self
     */
    public function clear()
    {
        return $this->set(null);
    }

    /**
     * Append method
     * 
     * @param array $params
     * 
     * @return
     */
    public function append(array $params)
    {

        return $this->set($params, true);
    }

    /**
     * delete method
     * 
     * @param array $keys
     * 
     * @return
     */
    public function remove(array $keys)
    {

        $readOld = (array) $this->read();

        // Check found old data
        if (!$readOld) return $this;

        // Remove keys
        foreach ($keys as $key) {

            unset($readOld[$key]);
        }

        // Set route null and Set cleared data
        return $this->set(null)->set($readOld);
    }

    /**
     * Save method
     * 
     * @param bool $minify
     */
    function save(bool $minify = false)
    {
        // Encode and organize code
        $newData = json_encode($this->json, ($minify ? 0 : JSON_PRETTY_PRINT) | JSON_UNESCAPED_UNICODE);

        // Save new data
        file_put_contents($this->filepath, $newData);
    }
}
