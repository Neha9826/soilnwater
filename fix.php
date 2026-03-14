<?php
// fix.php - Place this in your public_html folder

use Illuminate\Support\Facades\Artisan;

// 1. Load the Laravel Application
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

echo "<h2>System Fix Started...</h2>";

try {
    // 2. Clear all the "old" info so Laravel sees your new .env and code
    echo "1. Clearing old configuration... ";
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    echo "<b>Done</b><br>";

    // 3. Fix the broken Storage link (The main reason for 404s)
    echo "2. Repairing Storage link... ";
    if (file_exists(public_path('storage'))) {
        // Remove the old/broken link first
        if (is_link(public_path('storage'))) {
            unlink(public_path('storage'));
        }
    }
    
    // Create the fresh link
    Artisan::call('storage:link');
    echo "<b>Done</b><br>";

    echo "<h3>Success! Refresh your Admin Panel now.</h3>";
} catch (\Exception $e) {
    echo "<br><b style='color:red;'>Error:</b> " . $e->getMessage();
}