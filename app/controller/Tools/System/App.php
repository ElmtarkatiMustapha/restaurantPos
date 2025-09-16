<?php

namespace TOOL\System;

use TOOL\SQL\Database;
use TOOL\SQL\SQL;

class App
{

    /**
     * PATH_CONFIG
     * 
     * @var string
     */
    private const PATH_CONFIG = BASEDIR . '/.config';

    /**
     * Config
     * 
     * @var ?object
     */
    private static ?object $config = NULL;


    /**
     * Config method
     * 
     * @param bool $render
     * 
     * @return object
     */
    static function config(bool $render = false)
    {

        // Check has setup
        if (self::$config && !$render) return self::$config;

        return self::$config = JSON::open(self::PATH_CONFIG)->read();
    }

    /**
     * Set method
     * 
     * @param string $key
     * 
     * @param $value
     * 
     * @param bool $replace
     */
    static function set(string $key, $value, $replace = false)
    {

        if ($replace || !isset(self::config()->{$key}))
            JSON::open(self::PATH_CONFIG)->set([$key => $value])->save();

        // Render config
        self::config(true);
    }

    /**
     * Remove config method
     * 
     * @param array $keys
     */
    static function removeConfig(array $keys)
    {

        JSON::open(self::PATH_CONFIG)->remove($keys)->save();

        // Ready config to render
        self::$config = NULL;
    }

    /**
     * Install method
     * 
     */
    static function install()
    {

        // Check config is exits
        if (!file_exists(self::PATH_CONFIG))
            JSON::create(self::PATH_CONFIG);

        // Define config
        $config = (array) JSON::open(BASEDIR . '/sample.config')->set(

            // Read old config
            (array) JSON::open(self::PATH_CONFIG)->read()
        )->read();

        // Update config
        JSON::open(self::PATH_CONFIG)
            ->clear()
            ->set($config)
            ->save();

        // Reander config
        self::config(true);

        // Make storage
        Path::open(BASEDIR)
            ->make('storage');

        // Install changes
        require BASEDIR . '/controller/install.php';
    }

    /**
     * Format method
     * 
     * @return
     */
    static function format()
    {
        // Clear database
        $database = config('DATABASE_NAME');
        SQL::run("DROP database `{$database}`; CREATE database `{$database}`;");

        // Render database
        Database::conn(true);

        // Delete storage
        Path::open(BASESTORAGE)->delete();
    }

    /**
     * Backup
     * 
     * @return string
     */
    static function backup()
    {

        // Set long time
        set_time_limit(1000000000);

        // Check backups dir
        if (!is_dir(BASESTORAGE . '/backups'))
            Path::open(BASESTORAGE)->make('backups');

        // Export database
        Database::export(BASESTORAGE . '/database', 'last-sql-database');

        // Define file name
        $filename = config('APP_NAME', 'APP') . ' (backup ' . date('Y-m-d H.i.s') . ')';

        // Zip backup
        Path::open(BASEDIR)->skip([
            'build',
            'storage/backups',
            'controller/vendor',
            'interface/web/node_modules',
            'interface/mobile/node_modules'
        ])->zip($filename, BASESTORAGE . '/backups');

        return "{$filename}.zip";
    }
}
