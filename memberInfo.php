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
$uuid = isset($_SESSION["uuid"]) ? $_SESSION["uuid"] : "";
$loginAccount = isset($_SESSION["account"]) ? $_SESSION["account"] : "";

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

    // 修改會員資料
}

// 最高管理者
if ($permission == "最高") {
    echo $tpl->render('/_memberInfoTop.html');

    /**
     * 撈單一會員資料
     */
    if (isset($_POST['s1']) && !empty($_POST['t1'])) {
        $memberAccount = $_POST['t1'];
        $row = $db->searchMemberByAccount($memberAccount);
        if (!$row) {
            echo "<script>alert('查無此會員');</script>";
            $sql = "select id, account, name, permission from member where is_delete = 0";
            $result = $db->query($sql);
            $fields = mysqli_num_fields($result);
            $meta = mysqli_fetch_fields($result);
            $fn = [];
            foreach ($meta as $m) {
                $fn[] = $m->name;
            }
        } else {
            // 過濾欄位
            $desired = ['id', 'account', 'name', 'permission'];
            $result = array_intersect_key($row, array_flip($desired));

            // 這裡欄位名稱就用 array_keys()
            $fields = count($result);
            $fn = array_keys($result);
        }
    } else {
        $sql = "select id, account, name, permission from member where is_delete = 0";
        $result = $db->query($sql);
        $fields = mysqli_num_fields($result);
        $meta = mysqli_fetch_fields($result);
        $fn = [];
        foreach ($meta as $m) {
            $fn[] = $m->name;
        }
    }

    echo "<div id='dv1'><table border='2'><!-- topic start --><tr id='topic'>";
    for (
        $u = 0;
        $u < $fields;
        $u++
    ) {
        echo "<td bgcolor='#1D438A' style='color: white';>" . $fn[$u] . "</td>";     //調出所有欄位的名稱用 ->name
    }

    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_row($result)) {     //取得所有記錄列
            echo "<tr>";
            echo "<td>" . $row[0] . "</td>";
            echo "<td>" . $row[1] . "</td>";
            echo "<td>" . $row[2] . "</td>";
            echo "<td>" . $row[3] . "</td>";
            echo "</tr>";
        }
    } else {
        // 處理單一會員資料的情況
        echo "<tr>";
        echo "<td>" . $result["id"] . "</td>";
        echo "<td>" . $result["account"] . "</td>";
        echo "<td>" . $result["name"] . "</td>";
        echo "<td>" . $result["permission"] . "</td>";
        echo "</tr>";

        $variables = [
            'id'            => $result["id"],
            'account'       => $result["account"],
            'name'          => $result["name"],
            'permission'    => $result["permission"],
        ];

        $id         = $result["id"];
        $account    = $result["account"];
        $name       = $result["name"];
        $permission = $result["permission"];
    }

    // 刪除會員
    if (isset($_POST['s4']) && $loginAccount == $_POST['qt2']) {
        echo "<script>alert('錯誤!!無法刪除自己的帳號')</script>";
    }

    if (isset($_POST['s4']) && !empty($_POST['qt2']) && $loginAccount != $_POST['qt2']) {
        $memberAccount = $_POST['qt2'];
        $isDelete = 1; // 設定為刪除狀態
        $result = $db->updateMemberInfo($memberAccount, $isDelete);
        if ($result) {
            echo "<script>location.href='./memberInfo.php';</script>";
        }
    }

    // 修改會員權限
    if (isset($_POST['s5'])) {
        $account = isset($_POST['qt2']) ? $_POST['qt2'] : $account;
        $name1 = isset($_POST['qt3']) ? $_POST['qt3'] : $name;
        $permission1 = isset($_POST['qt4']) ? $_POST['qt4'] : $permission;

        // echo "<script>console.log('" . $account . $name1 . $permission1 . "')</script>";

        $result = $db->updateMemberInfo($account, 0, $name1, $permission1);
        if ($result) {
            echo "<script>location.href='./memberInfo.php';</script>";
        }
    }

    echo $tpl->render('/_memberInfoAdmin.html', $variables);
}


// footer
echo $tpl->render('/footer.html');

$db->close();
// 主程式結束
