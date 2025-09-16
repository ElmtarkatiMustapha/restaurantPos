<?php

/*
|--------------------
| Disable all errors
|--------------------
|
|
*/

error_reporting(0);

/*
|------------------------
| POST requests accepted
|------------------------
|
|
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(500);
    exit;
}


/*
|-----------------------------
| Check reference and version
|-----------------------------
|
|
*/

$ref = $_POST['ref'];
$ver = floatval($_POST['ver']);

if (!$ref || !$ver || in_array($ref, ['.', '..'])) exit;

/*
|---------------
| Scan apps dir
|---------------
|
|
*/

$appsPath = __DIR__ . '/../../apps';

$apps = scandir($appsPath);

if (!in_array($ref, $apps)) exit;

/*
|---------------
| Scan versions
|---------------
|
|
*/

$versions = scandir("{$appsPath}/{$ref}");

$versions = array_filter($versions, function ($version) {
    return $version !== '.' && $version !== '..';
});

$versions = array_map(function ($version) {
    return floatval($version);
}, $versions);

$versions = array_values($versions);

$lastVersion = max($versions);

/*
|-----------------------
| Check update is logic
|-----------------------
| Compare last version with old version
|
|
*/

if ($ver >= $lastVersion) exit;

/*
|----------------------
| Get version document
|----------------------
|
|
|
*/
$versionPath = "{$appsPath}/{$ref}/{$lastVersion}";

if (!file_exists("{$versionPath}/build.zip")) exit;

if (!isset($_POST['updateTo'])) {
    die(file_get_contents("{$versionPath}/document.json"));
    exit;
}

/*
|-----------------
| Generate update
|-----------------
|
|
*/
$updateTo = floatval($_POST['updateTo']);

$versionPath = "{$appsPath}/{$ref}/{$updateTo}/build.zip";

if (!file_exists($versionPath)) exit;

header("Content-Type: application/zip");

die(file_get_contents($versionPath));
