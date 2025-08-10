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

// Detect current repo folder name (the folder where this script is running)
$repoDir = basename(__DIR__);

// Laravel install path (one directory up from current repo)
$installPath = "../{$projectName}";

echo "\n🚀 Installing Laravel into: $installPath\n";
runCommand("laravel new " . escapeshellarg($installPath));

// Step 1: Install Laravel Breeze
chdir($installPath);
echo "\n📦 Installing Laravel Breeze...\n";
runCommand("composer require laravel/breeze --dev");
runCommand("php artisan breeze:install");
runCommand("npm install");
runCommand("npm run build");

// Step 2: Move assets folder from repo root to Laravel public folder
echo "\n📂 Moving assets...\n";
if (is_dir(__DIR__ . "/assets")) {
    rename(__DIR__ . "/assets", "public/assets");
    echo "✅ Assets moved to public/assets\n";
} else {
    echo "⚠️ assets folder not found in repository root.\n";
}

// Step 3: Move app.blade.php into Laravel views/layouts
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

// Step 3.1: Move header.blade.php into Laravel views/layouts
echo "\n📝 Moving header.blade.php...\n";
if (file_exists(__DIR__ . "/header.blade.php")) {
    if (!is_dir("resources/views/layouts")) {
        mkdir("resources/views/layouts", 0777, true);
    }
    rename(__DIR__ . "/header.blade.php", "resources/views/layouts/header.blade.php");
    echo "✅ header.blade.php moved to resources/views/layouts/\n";
} else {
    echo "⚠️ header.blade.php not found.\n";
}

// Step 3.2: Move sidebar.blade.php into Laravel views/layouts
echo "\n📝 Moving sidebar.blade.php...\n";
if (file_exists(__DIR__ . "/sidebar.blade.php")) {
    if (!is_dir("resources/views/layouts")) {
        mkdir("resources/views/layouts", 0777, true);
    }
    rename(__DIR__ . "/sidebar.blade.php", "resources/views/layouts/sidebar.blade.php");
    echo "✅ sidebar.blade.php moved to resources/views/layouts/\n";
} else {
    echo "⚠️ sidebar.blade.php not found.\n";
}

// Step 3.3: Move 2025_08_09_182304_create_menus_table.php to database/migrations
echo "\n📝 Moving 2025_08_09_182304_create_menus_table.php...\n";
if (file_exists(__DIR__ . "/2025_08_09_182304_create_menus_table.php")) {
    if (!is_dir("database/migrations")) {
        mkdir("database/migrations", 0777, true);
    }
    rename(__DIR__ . "/2025_08_09_182304_create_menus_table.php", "database/migrations/2025_08_09_182304_create_menus_table.php");
    echo "✅ 2025_08_09_182304_create_menus_table.php moved to database/migrations/\n";
} else {
    echo "⚠️ 2025_08_09_182304_create_menus_table.php not found.\n";
}

// Step 3.4: Move Menu.php to app/Models
echo "\n📝 Moving Menu.php...\n";
if (file_exists(__DIR__ . "/Menu.php")) {
    if (!is_dir("app/Models")) {
        mkdir("app/Models", 0777, true);
    }
    rename(__DIR__ . "/Menu.php", "app/Models/Menu.php");
    echo "✅ Menu.php moved to app/Models/\n";
} else {
    echo "⚠️ Menu.php not found.\n";
}

// Step 3.5: Replace login.blade.php in resources/views/auth
echo "\n📝 Replacing login.blade.php...\n";
if (file_exists(__DIR__ . "/login.blade.php")) {
    if (!is_dir("resources/views/auth")) {
        mkdir("resources/views/auth", 0777, true);
    }
    rename(__DIR__ . "/login.blade.php", "resources/views/auth/login.blade.php");
    echo "✅ login.blade.php replaced in resources/views/auth/\n";
} else {
    echo "⚠️ login.blade.php not found.\n";
}

// Step 3.6: Replace register.blade.php in resources/views/auth
echo "\n📝 Replacing register.blade.php...\n";
if (file_exists(__DIR__ . "/register.blade.php")) {
    if (!is_dir("resources/views/auth")) {
        mkdir("resources/views/auth", 0777, true);
    }
    rename(__DIR__ . "/register.blade.php", "resources/views/auth/register.blade.php");
    echo "✅ register.blade.php replaced in resources/views/auth/\n";
} else {
    echo "⚠️ register.blade.php not found.\n";
}

// Step 3.7: Replace web.blade.php
echo "\n📝 Replacing web.blade.php...\n";
if (file_exists(__DIR__ . "/web.blade.php")) {
    if (!is_dir("resources/views")) {
        mkdir("resources/views", 0777, true);
    }
    rename(__DIR__ . "/web.blade.php", "resources/views/web.blade.php");
    echo "✅ web.blade.php replaced in resources/views/\n";
} else {
    echo "⚠️ web.blade.php not found.\n";
}

// Step 4: Move sidebar.php into Laravel config folder
echo "\n⚙️ Moving sidebar.php...\n";
if (file_exists(__DIR__ . "/sidebar.php")) {
    rename(__DIR__ . "/sidebar.php", "config/sidebar.php");
    echo "✅ sidebar.php moved to config/\n";
} else {
    echo "⚠️ sidebar.php not found.\n";
}

// Go back one level from Laravel project directory before deleting repo
chdir('..');

echo "\n🗑️ Deleting cloned repository folder: $repoDir\n";
runCommand("rm -rf " . escapeshellarg(__DIR__));

echo "\n🎉 Setup completed successfully!\n";
