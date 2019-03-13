<?php
ini_set("display_errors", 1);
ob_start();
$session_timeout = 86400;
// Set the max lifetime of session
ini_set("session.gc_maxlifetime", $session_timeout);
// Set the session cookie to timout
ini_set("session.cookie_lifetime", $session_timeout);
session_start();
define('BASE_PATH', realpath(__DIR__.''));
#-----------------------------------
# Autoload classes
#----------------------------------
if (file_exists(BASE_PATH.'/vendor/autoload.php')) {
    require_once BASE_PATH.'/vendor/autoload.php';
} else {
    echo "<h1>Please install via composer.json</h1>";
    echo "<p>Install Composer instructions: <a href='https://getcomposer.org/doc/00-intro.md#globally'>https://getcomposer.org/doc/00-intro.md#globally</a></p>";
    echo "<p>Once composer is installed navigate to the working directory in your terminal/command promt and enter 'composer install'</p>";
    exit;
}

require_once 'functions.php';
$db = \Classes\Db::getInstance();