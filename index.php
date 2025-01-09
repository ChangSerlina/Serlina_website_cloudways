<?php

/**
 * 首頁
 * 計算網站訪客人數
 */

use tpl\Tpl;

include_once('tpl.class.php');
$tpl = new Tpl(__DIR__ . '/html');

session_start();

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : "";
$uuid = isset($_SESSION["uuid"]) ? $_SESSION["uuid"] : "";

//主程式開始
$countFile = "counter.txt";

//檢查計數檔案是否存在
if (!file_exists($countFile)) {
    $counter = 0;
    $file = fopen($countFile, "w");
    fputs($file, $counter);
    fclose($file);
} else {
    $file = fopen($countFile, "r+");
    //以位元組的方式讀取檔案
    $counter = fread($file, filesize($countFile));
    fclose($file);
}

$counter += 1;

//寫入檔案
$file = fopen($countFile, "w+");
fputs($file, $counter);
fclose($file);

//顯示網站人數
// echo "訪客人數：".$counter;

$variables = [
    'user' => $user,
    'uuid' => $uuid,
    'visitors' => $counter,
];

echo $tpl->render('/header.html');

if (!empty($user)) {
    echo $tpl->render('/_signout.html', $variables);
} else {
    echo $tpl->render('/_signin.html');
}

echo $tpl->render('/_home.html', $variables);
echo $tpl->render('/footer.html');
