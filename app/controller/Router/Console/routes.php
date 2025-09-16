<?php

use TOOL\Console\Console;

// Usage
Console::route('usage', __DIR__ . '/routes/usage.php');

// Install
Console::route('install', __DIR__ . '/routes/install.php');

// Format
Console::route('format', __DIR__ . '/routes/format.php');

// Reinstall
Console::route('reinstall', __DIR__ . '/routes/reinstall.php');

// Start
Console::route('start', __DIR__ . '/routes/start.php');

// Backup
Console::route('backup', __DIR__ . '/routes/backup.php');

// Generate version
Console::route('generate-version', __DIR__ . '/routes/generateVersion.php');

// Update
Console::route('update', __DIR__ . '/routes/update.php');

// Build
Console::route('build', __DIR__ . '/routes/build.php');

// Env
Console::route('env', __DIR__ . '/routes/env.php');
