<?php

namespace TOOL\System;

use TOOL\Network\Network;
use TOOL\System\JSON;

class Update
{

    /**
     * Update path
     * 
     * @var string
     */
    private const UPDATE_PATH = BASEDIR . '/update.json';


    /**
     * Config method
     * 
     * @return
     */
    static function config()
    {
        return JSON::open(self::UPDATE_PATH)->read();
    }

    /**
     * Config method
     * 
     * @param array $params
     */
    static function set(array $params)
    {

        JSON::open(self::UPDATE_PATH)->set($params)->save();
    }

    /**
     * Search method
     * 
     * @return object
     */
    static function search()
    {

        // Config
        $Config = self::config();

        $content = Network::curl($Config->downloadBase, [
            'ref' => $Config->reference,
            'ver' => $Config->data->version
        ]);

        if (!$content)
            return null;

        $data = json_decode($content);

        return [
            'version' => (float) $data->version,
            'type' => (string) $data->type,
            'date' => (string) $data->date,
            'changes' => (array) $data->changes
        ];
    }

    /**
     * Download method
     * 
     * @param float $version
     */
    static function download(float $version)
    {
        // Set long time
        set_time_limit(100000000);

        // Config
        $Config = self::config();

        // Check is logic update
        if ($version <= $Config->data->version)
            throw new \Error('You can\'t update to old version');

        // Download
        $content = Network::curl($Config->downloadBase, [
            'ref' => $Config->reference,
            'ver' => $Config->data->version,
            'updateTo' => $version
        ]);

        // Check is found content
        if (!$content)
            throw new \Error("Not found this version");

        // Backup
        App::backup();

        // Define archive
        $archive = BASEDIR . '/update.zip';

        // Save archive
        file_put_contents($archive, $content);

        // Check is zip
        if (!Path::isZip($archive)) {
            unlink($archive);
            throw new \Error("Error for this archive");
        }

        // Clear old
        Path::open(BASEDIR)
            ->skip(['update.zip', '.config', 'storage'])
            ->clear();

        // Extractor
        Path::open(BASEDIR)->unzip($archive);

        // Delete archive
        unlink($archive);
    }

    /**
     * Verify method
     * 
     */
    static function verify()
    {
        if (!self::config()->completed) {
            App::install();

            // Set completed = true
            self::set(['completed' => true]);
        }
    }

    /**
     * Generate version method
     * 
     * @param bool $stable
     * 
     * @return object
     */
    static function generateVersion(bool $stable)
    {
        // Define version
        $version = floatval(number_format(Update::config()->data->version + 0.1, 1));

        self::set([
            'data' => [
                'type' => $stable ? 'stable' : 'beta',
                'version' => $version,
                'date' => date('Y-m-d'),
                'changes' => null
            ]
        ]);

        return (object) [
            'number' => $version,
            'type' => $stable ? 'stable' : 'beta'
        ];
    }
}
