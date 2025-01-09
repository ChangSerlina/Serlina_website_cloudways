<?php
/**
 * 旅遊景點頁面
 */

use tpl\Tpl;

include_once('tpl.class.php');
$tpl = new Tpl(__DIR__ . '/html');

session_start();

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : "";
$uuid = isset($_SESSION["uuid"]) ? $_SESSION["uuid"] : "";

$variables = [
    'user' => $user,
    'uuid' => $uuid,
];

// header
echo $tpl->render('/header.html');

// member login/out
if (!empty($user)) {
    echo $tpl->render('/_signout.html', $variables);
} else {
    echo $tpl->render('/_signin.html');
}

// main
echo $tpl->render('/_attraction.html');
// footer
echo $tpl->render('/footer.html');