<?php
ini_set("display_errors", 0);
ob_start();

// Define Base Path
define('BASE_PATH', realpath(__DIR__.''));

// Require functions php
require_once 'functions.php';

$session_timeout = config('session_lifetime');

// Set the max lifetime of session
ini_set("session.gc_maxlifetime", $session_timeout);

// Set the session cookie to timout
ini_set("session.cookie_lifetime", $session_timeout);

//start session
session_start();

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

// Connect to Database
$db = \Classes\Db::getInstance();