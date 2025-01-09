<?php

/**
 * 旅遊規劃頁面
 */

use tpl\Tpl;

include_once('tpl.class.php');
$tpl = new Tpl(__DIR__ . '/html');

require_once('./lib/db_lib.php');     //mysql連線
$db = new Database();

session_start();

$id = "";
$name = "";
$birthday = "";
$blood = "";
$school = "";

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : "";
$uuid = isset($_SESSION["uuid"]) ? $_SESSION["uuid"] : "";

$variables = [
    'user' => $user,
    'uuid' => $uuid,
];

/**
 * 頁面渲染 上
 */
echo $tpl->render('/header.html');
if (!empty($user)) {
    echo $tpl->render('/_signout.html', $variables);
} else {
    echo $tpl->render('/_signin.html');
}

echo $tpl->render('/_basicdbTop.html', $variables);

/**
 * 取得變數，撈資料
 */
if (isset($_POST['s1'])) {
    $id = $_POST['t1'];
    $sql = "select * from plan where 行程 = '" . $id . "' ";
} elseif (isset($_POST['s2'])) {
    $sql = "select * from plan";
} else {
    $sql = "select * from plan";
}

$result = $db->query($sql);
$rows = mysqli_num_rows($result);
$fields = mysqli_num_fields($result);

$fn = mysqli_fetch_fields($result);    //一維陣列，取得所有欄位，記得field要加"s"
for (
    $u = 0;
    $u < $fields;
    $u++
) {
    echo "<td bgcolor='#FA527A'>" . $fn[$u]->name . "</td>";     //調出所有欄位的名稱用 ->name
}

while ($row = mysqli_fetch_row($result)) {     //取得所有記錄列
    echo "<tr>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    echo "<td>" . $row[2] . "</td>";
    echo "<td>" . $row[3] . "</td>";
    echo "<td>" . $row[4] . "</td>";
    echo "</tr>";

    if (isset($_POST['s1'])) {
        $id         = $row[0];
        $name       = $row[1];
        $birthday   = $row[2];
        $blood      = $row[3];
        $school     = $row[4];
    }
}

// 新增指令
if (isset($_POST['s3'])) {
    $iid = $_POST['qt1'];
    if ($iid != "") {
        $result = checkid($db, $iid);
        //                        echo $result;
        if ($result == 0) {
            $iname = $_POST['qt2'];
            $ibirth = $_POST['qt3'];
            $iblood = $_POST['qt4'];
            $ischool = $_POST['qt5'];
            $sql = "insert into plan value( '" . $iid . "' , '" . $iname . "' , '" . $ibirth . "' , '" . $iblood . "' , '" . $ischool . "' )";
            modifydata($db, $sql);    //新增、刪除、修改都共用一個函數就可以了 (因為差別在sql指令)
        } else {
            echo "<script>alert('此筆資料已存在---不可以新增')</script>";
        }
    } else {
        echo "<script>alert('請輸入資料或先進行查詢')</script>";
    }
}

// 刪除指令
if (isset($_POST['s4'])) {
    $did = $_POST['qt1'];
    if (empty($did)) {
        echo "<script>alert('請先進行查詢')</script>";
    } else {
        $sql = "delete from plan where 編號='" . $did . "';";
        modifydata($db, $sql);    //新增、刪除、修改都共用一個函數就可以了 (因為差別在sql指令)
    }
}

// 修改指令
if (isset($_POST['s5'])) {
    $did = $_POST['qt1'];
    if (empty($did)) {
        echo "<script>alert('請先進行查詢')</script>";
    } else {
        $iname = $_POST['qt2'];
        $ibirth = $_POST['qt3'];
        $iblood = $_POST['qt4'];
        $ischool = $_POST['qt5'];
        $sql = "update plan set 出發點='" . $iname . "' , 目的地= '" . $ibirth . "' , 預計天數= '" . $iblood . "' , 沿途景點= '" . $ischool . "' where 行程= '" . $did . "';";
        modifydata($db, $sql);    //新增、刪除、修改都共用一個函數就可以了 (因為差別在sql指令)
    }
}

// 讀取(更新)指令
if (isset($_POST['s6'])) {
    // header("Location:basicdb.php");
    echo "<script>location.href='./basicdb.php';</script>";
}

function checkid($db, $id)
{
    $sql = "select * from plan where 行程 = '" . $id . "' ";
    $result = $db->query($sql);
    $rows = mysqli_num_rows($result);
    // echo "count: " . $rows;
    if ($rows != 0) {
        return 1;
    } else {
        return 0;
    }
}

function modifydata($db, $sql)
{
    $db->query($sql);
    // header("Location:basicdb.php");                  //                        轉向指令
    echo "<script>location.href='./basicdb.php';</script>";
}

$result->close();
$db->close();

$variables = [
    'id'        => $id,
    'name'      => $name,
    'birthday'  => $birthday,
    'blood'     => $blood,
    'school'    => $school,
];

/**
 * 頁面渲染 下
 */
echo $tpl->render('/_basicdbBottom.html', $variables);
echo $tpl->render('/footer.html');
