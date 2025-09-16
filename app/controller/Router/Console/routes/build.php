<?php

use TOOL\Console\Console;
use TOOL\System\JSON;
use TOOL\System\Path;
use TOOL\System\Update;

// Build for web
if (Console::$props->web || Console::$props->all) {
    echo "Clear old web interface \n";
    Path::open(BASEPUBLIC)->go('web')->clear();

    echo "Build new web interface \n";
    Path::open(BASEINTERFACE)
        ->go('web')
        ->command("npm run production")
        ->go('/build')->move(BASEPUBLIC . '/web');
    echo "---------------------------- \n";
}

// Build for mobile
if (Console::$props->mobile || Console::$props->all) {
    echo "Clear old mobile interface \n";
    Path::open(BASEPUBLIC)->go('mobile')->clear();

    echo "Build new mobile interface \n";
    Path::open(BASEINTERFACE)
        ->go('mobile')
        ->command("npm run build")
        ->go('/dist')->move(BASEPUBLIC . '/mobile');
    echo "---------------------------- \n";
}

// Export
if (Console::$props->export) {

    echo "Export app \n";
    Path::open(BASEDIR)->make('build/' . Update::config()->data->version)->do(function ($path) {
        JSON::create("{$path}/document.json", true)->set((array) Update::config()->data)->save();
    });

    echo "Set completed = false \n";
    Update::set(['completed' => false]);

    Path::open(BASEDIR)->skip(
        Console::$props->source ?
            ['.config', 'storage', 'build', 'interface/web/node_modules', 'interface/mobile/node_modules'] :
            ['.config', 'storage', 'build', 'interface']
    )->zip('build', BASEDIR . '/build/' . Update::config()->data->version);

    echo "Set completed = true \n";
    Update::set(['completed' => true]);
    echo "---------------------------- \n";
}

echo "Done \n";
