<?php
/**
 * 會員資料登錄
 */

use tpl\Tpl;

include_once('tpl.class.php');
$tpl = new Tpl(__DIR__ . '/html');

session_start();

$account = isset($_SESSION["account"]) ? $_SESSION["account"] : "";

echo $tpl->render('/_member.html');
