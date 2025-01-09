<?php
/**
 * 確認驗證碼
 */
include_once('captcha.php');
session_start();
$action     = (isset($_GET['action']))?$_GET['action']:"";

switch($action){
    /**
     * 產生驗證碼
     */
    case "getcaptcha":
        $str = "";
        if($str == ""){
            $str = rand_str(5);
        }
        create_captcha($str);
        break;
    /**
     * 驗證輸入的驗證碼
     */
    case "checkcaptcha":
        $str        = strtolower($_SESSION['captcha']);
        $postCheck  = strtolower($_POST["check"]);
        if($str == $postCheck){
            echo "pass";
        }
        break;
    default:
        exit;
}
?>