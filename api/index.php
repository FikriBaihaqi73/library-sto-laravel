<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    echo "<h1>Eror: Autoloader (vendor) tidak ditemukan!</h1>";
    echo "<p>Coba jalankan 'composer install' secara lokal lalu push folder vendor-nya, atau pastikan Vercel menjalankan composer install.</p>";
    exit;
}

require __DIR__ . '/../public/index.php';
