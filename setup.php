<?php
// Function to run shell commands
function runCommand($command) {
    echo "\n> $command\n";
    passthru($command, $status);
    if ($status !== 0) {
        echo "\n❌ Command failed: $command\n";
        exit(1);
    }
}

// Step 0: Ask user for Laravel project name
echo "Enter Laravel project name: ";
$projectName = trim(fgets(STDIN));

if (empty($projectName)) {
    echo "❌ Project name cannot be empty.\n";
    exit(1);
}

// Step 1: Install Laravel (using Laravel Installer)
echo "\n🚀 Installing Laravel with Laravel Installer...\n";
runCommand("laravel new {$projectName}");

// Step 2: Install Laravel Breeze
chdir($projectName);
echo "\n📦 Installing Laravel Breeze...\n";
runCommand("composer require laravel/breeze --dev");
runCommand("php artisan breeze:install");
runCommand("npm install");
runCommand("npm run build");

// Step 3: Move assets folder
echo "\n📂 Moving assets...\n";
if (is_dir("../assets")) {
    rename("../assets", "public/assets");
    echo "✅ Assets moved to public/assets\n";
} else {
    echo "⚠️ assets folder not found in repository root.\n";
}

// Step 4: Replace app.blade.php
echo "\n📝 Replacing app.blade.php...\n";
if (file_exists("../app.blade.php")) {
    if (!is_dir("resources/views/layouts")) {
        mkdir("resources/views/layouts", 0777, true);
    }
    copy("../app.blade.php", "resources/views/layouts/app.blade.php");
    echo "✅ app.blade.php replaced.\n";
} else {
    echo "⚠️ app.blade.php not found.\n";
}

// Step 5: Move sidebar.php to config
echo "\n⚙️ Moving sidebar.php...\n";
if (file_exists("../sidebar.php")) {
    rename("../sidebar.php", "config/sidebar.php");
    echo "✅ sidebar.php moved to config.\n";
} else {
    echo "⚠️ sidebar.php not found.\n";
}

echo "\n🎉 Setup completed successfully!\n";
