<?php
function runCommand($command) {
    echo "\n> $command\n";
    passthru($command, $status);
    if ($status !== 0) {
        echo "\n❌ Command failed: $command\n";
        exit(1);
    }
}

// Step 0: Ask for Laravel project name
echo "Enter Laravel project name: ";
$projectName = trim(fgets(STDIN));
if (empty($projectName)) {
    echo "❌ Project name cannot be empty.\n";
    exit(1);
}

// Detect current repo folder name
$repoDir = basename(__DIR__);

// Laravel install path (one level up from repo)
$installPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $projectName;

echo "\n🚀 Installing Laravel into: $installPath\n";
runCommand("laravel new \"$installPath\"");

// Step 1: Install Laravel Breeze
chdir($installPath);
echo "\n📦 Installing Laravel Breeze...\n";
runCommand("composer require laravel/breeze --dev");
runCommand("php artisan breeze:install");
runCommand("npm install");
runCommand("npm run build");

// Step 2: Move assets folder
echo "\n📂 Moving assets...\n";
if (is_dir(__DIR__ . "/assets")) {
    rename(__DIR__ . "/assets", "public/assets");
    echo "✅ Assets moved to public/assets\n";
} else {
    echo "⚠️ assets folder not found in repository root.\n";
}

// Step 3: Move app.blade.php
echo "\n📝 Moving app.blade.php...\n";
if (file_exists(__DIR__ . "/app.blade.php")) {
    if (!is_dir("resources/views/layouts")) {
        mkdir("resources/views/layouts", 0777, true);
    }
    rename(__DIR__ . "/app.blade.php", "resources/views/layouts/app.blade.php");
    echo "✅ app.blade.php moved to resources/views/layouts/\n";
} else {
    echo "⚠️ app.blade.php not found.\n";
}

// Step 4: Move sidebar.php to config
echo "\n⚙️ Moving sidebar.php...\n";
if (file_exists(__DIR__ . "/sidebar.php")) {
    rename(__DIR__ . "/sidebar.php", "config/sidebar.php");
    echo "✅ sidebar.php moved to config/\n";
} else {
    echo "⚠️ sidebar.php not found.\n";
}

// Step 5: Delete the repo folder
echo "\n🗑️ Deleting cloned repository folder: $repoDir\n";
runCommand("rm -rf \"" . __DIR__ . "\"");

echo "\n🎉 Setup completed successfully!\n";
