<?php

session_start();

spl_autoload_register(function($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);

    include_once __DIR__ . '/' . $className . '.php';
});

$dbInfo = parse_ini_file("/srv/http/whtool/config/db.ini");
$pdo = new PDO($dbInfo['dsn'], $dbInfo['user'], $dbInfo['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$querie = new SqlQueries($pdo);



 $mapFile = file('/home/nikson/Downloads/whdata.csv');
    for ($index = 0; $index < count($mapFile); $index++) {
        if ($index != 0) {
            $temp = preg_split('/\t/', $mapFile[$index]);
            $cell = str_replace('"', '', $temp[0]);
            $sapNums = str_replace('"', '', $temp[1]);
            $updateDate = str_replace('"', '', $temp[2]);
            $querie->updateMapCells($cell, $sapNums, $updateDate);
        }
    }


