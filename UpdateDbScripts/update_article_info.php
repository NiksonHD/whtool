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


 $onstockFile = file('/home/nikson/Downloads/on_stock.csv');

    for ($index = 0; $index < count($onstockFile); $index++) {
        if ($index != 0) {
            $temp = preg_split('/\t/', $onstockFile[$index]);
            $sapNum = $temp[0];
            $name = $temp[1];
            $ean = $temp[9];
            $quantity = $temp[2];
            $updateDate = 
            $querie->updateQuantityAndEan($sapNum, $ean, $quantity);
            $articleInfo = $querie->getArticleInfoBySap($sapNum);
            if ($articleInfo['sap_num'] == '') {
                $querie->createArticleInfo($sapNum, $name, $ean, $quantity);
            }
        }
    }



        
//$db = new \Database\PDODatabase($pdo);



//$repository = new \App\Repository\Tiles\TileRepository($db, $dataBinder);
//$encryptionService = new \App\Service\Encryption\ArgonEncryptionService();
//$tileService = new \App\Service\Tiles\TileService($repository);
//$userService = new App\Service\UserService($userRepository, $encryptionService);
//$userHttpHandler = new \App\Http\UserHttpHandler($template, $dataBinder);
//$tileHttpHandler = new \App\Http\Tiles\TileHttpHandler($template, $dataBinder,$tileService);