<?php
include_once 'autoload.php';

$raw_sql = file_get_contents('database/battleship.sql');
$query = $db->getConnection()->exec($raw_sql);

if($db->getConnection()->errorCode() == 00000)
{
    echo '<center>Tables have been imported <br> <a href="/">Go to main page</a></center>';
}
else
{
    echo 'Mysql error code: '.$db->getConnection()->errorCode();
    echo 'Unable to create database tables';
}
