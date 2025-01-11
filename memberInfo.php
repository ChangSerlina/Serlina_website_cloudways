<?php

/**
 * 管理頁面
 */

require_once('./lib/db_lib.php');     //mysql連線
$db = new Database();

use tpl\Tpl;

include_once('tpl.class.php');
$tpl = new Tpl(__DIR__ . '/html');

session_start();

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : "";
$uuid = isset($_GET["uuid"]) ? $_GET["uuid"] : "";

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
// 未登入會員
if (empty($uuid)) {
    echo $tpl->render('/error.html');
    echo "<script>document.getElementById('errorMessage').innerHTML = 'Oh! 您似乎尚未登入，3秒後即將幫您導回首頁...'; redirecIndex(); </script>";
    exit();
}

// 已登入會員，判斷管理權限
$result = $db->searchMemberByUUID($uuid);

$id         = isset($result["id"]) ? $result["id"] : "";
$account    = isset($result["account"]) ? $result["account"] : "";
$name       = isset($result["name"]) ? $result["name"] : "";
$permission = isset($result["permission"]) ? $result["permission"] : "";
$birthday   = isset($result["birthday"]) ? $result["birthday"] : "";
$gender     = isset($result["gender"]) ? $result["gender"] : "";
$education  = isset($result["education"]) ? $result["education"] : "";
$hobby      = isset($result["hobby"]) ? $result["hobby"] : "";

// 轉換性別為文字
if ($gender == 0) {
    $gender = "男";
}
if ($gender == 1) {
    $gender = "女";
}
if ($gender == 2) {
    $gender = "不公開";
}

$variables = [
    'id'            => $id,
    'account'       => $account,
    'name'          => $name,
    'permission'    => $permission,
    'birthday'      => $birthday,
    'gender'        => $gender,
    'education'     => $education,
    'hobby'         => $hobby,
];

// 沒有權限的會員
if ($permission == "讀取") {
    echo $tpl->render('/_memberInfoTop.html');
    echo "<div>";
    echo $tpl->render('/_memberInfoBottom.html', $variables);
}

// 有特定權限的會員
if ($permission == "修改") {
    echo $tpl->render('/_memberInfoTop.html');
    echo "<div>";
    echo $tpl->render('/_memberInfoBottom.html', $variables);
}

// 最高管理者
if ($permission == "最高") {
    echo $tpl->render('/_memberInfoTop.html');

    $sql = "select id, account, name, permission from member where is_delete = 0";
    $result = $db->query($sql);
    $fields = mysqli_num_fields($result);
    $fn = mysqli_fetch_fields($result);    //一維陣列，取得所有欄位，記得field要加"s"
    echo "<div id='dv1'><table border='2'><!-- topic start --><tr id='topic'>";
    for (
        $u = 0;
        $u < $fields;
        $u++
    ) {
        echo "<td bgcolor='#1D438A' style='color: white';>" . $fn[$u]->name . "</td>";     //調出所有欄位的名稱用 ->name
    }

    while ($row = mysqli_fetch_row($result)) {     //取得所有記錄列
        echo "<tr>";
        echo "<td>" . $row[0] . "</td>";
        echo "<td>" . $row[1] . "</td>";
        echo "<td>" . $row[2] . "</td>";
        echo "<td>" . $row[3] . "</td>";
        echo "</tr>";

        if (isset($_POST['s1'])) {
            $id         = $row[0];
            $account    = $row[1];
            $name       = $row[2];
            $permission = $row[3];
        }
    }
    echo $tpl->render('/_memberInfoAdmin.html', $variables);
}

// footer
echo $tpl->render('/footer.html');

$db->close();
// 主程式結束
