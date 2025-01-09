<?php
/**
 * 檢查/新增/修改 會員資料
 */
require_once('./lib/db_lib.php');     //mysql連線
$db = new Database();

session_start();

$action     = isset($_GET['action']) ? $_GET['action'] : "";
$account    = isset($_POST['email2']) ? $_POST['email2'] : "";
$passwd     = isset($_POST['pwd']) ? $_POST['pwd'] : "";

$userName    = isset($_POST['userName']) ? $_POST['userName'] : "";
$birthday    = isset($_POST['birthday']) ? $_POST['birthday'] : "";
$gender      = isset($_POST['gender']) ? $_POST['gender'] : "";
$education   = isset($_POST['edu']) ? $_POST['edu'] : "";
$hobby       = isset($_POST['hobby']) ? $_POST['hobby'] : "";

switch ($action) {
    case "checkMember":
        $result = $db->searchMemberByAccount($account);

        $user = isset($result["name"]) ? $result["name"] : "";
        if (!empty($user)) {
            echo "1";  //已有帳號
            error_log("account => " . $account . " is already exists ");
        } else {
            echo "0";  //沒有帳號
        }

        break;
    case "addMember":
        $uuid = generate_uuid();
        $hashedPassword = password_hash($passwd, PASSWORD_DEFAULT);

        $sql = "INSERT INTO member(uuid, account, password) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            echo "failed";  //新增會員失敗
            error_log("Add member => " . $account . " failed");
        } else {
            $stmt->bind_param("sss", $uuid, $account, $hashedPassword);
            $stmt->execute();
            $stmt->close();

            $_SESSION["account"] = $account;
            $_SESSION["uuid"] = $uuid;
        }

        break;
    case "updateMember":
        $account = isset($_SESSION["account"]) ? $_SESSION["account"] : "";

        //處理生日的type
        $date = new DateTime($birthday);
        $formatterDate = $date->format('Y-m-d');

        //處理hobby陣列
        if (is_array($hobby)) {
            $hobbyArray = implode(',', $hobby);
        }

        $sql = "UPDATE member SET `name` = ?, `birthday` = ?, `gender` = ?, `education` = ?, `hobby` = ? WHERE (`account` = ?)";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            echo "failed";  //修改會員資料失敗
            error_log("Modify member => " . $account . " failed");
        } else {
            $stmt->bind_param("ssssss", $userName, $formatterDate, $gender, $education, $hobby, $account);
            $stmt->execute();
            $stmt->close();
        }

        //搜尋註冊者
        $result = $db->searchMemberByAccount($account);
        if (!empty($result)) {
            $_SESSION["user"] = $result["name"];
        }

        break;
    case "memberLogin":
        $result = $db->searchMemberByAccount($account);

        $storedHashedPassword   = $result["password"];
        $user                   = $result["name"];
        $uuid                   = $result["uuid"];

        if (password_verify($passwd, $storedHashedPassword)) {
            $_SESSION["user"] = $user;
            $_SESSION["uuid"] = $uuid;
            echo "登入成功";
        } else {
            echo "登入失敗";
            error_log("inputPasswd =>" . $passwd);
            error_log("hashPasswd =>" . $storedHashedPassword);
        }

        break;
    case "logout":
        session_unset();
        session_destroy();
        echo "<script>location.href='index.php';</script>";
    default:
        exit;
}

$db->close();
// 主程式結束

/**
 * 產生隨機UUIDv4。
 * @return 字串 UUID
 */
function generate_uuid()
{
    $b = PHP_MAJOR_VERSION < 7 ? openssl_random_pseudo_bytes(16) : random_bytes(16);
    $b[6] = chr(ord($b[6]) & 0x0f | 0x40);
    $b[8] = chr(ord($b[8]) & 0x3f | 0x80);
    return  vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($b), 4));
}
