<?php
/**
 * 資料庫函式
 */

function searchMemberByAccount($mysqli, $account)
{
    $stmt = $mysqli->prepare("SELECT * FROM member where account = ?");
    $stmt->bind_param("s", $account);
    $stmt->execute();
    $sql_result = $stmt->get_result();
    $row = $sql_result->fetch_array(MYSQLI_ASSOC);

    return $row;
}

function searchMemberByUUID($mysqli, $uuid)
{
    $stmt = $mysqli->prepare("SELECT * FROM member where uuid = ? limit 1");
    $stmt->bind_param("s", $uuid);
    $stmt->execute();
    $sql_result = $stmt->get_result();
    $row = $sql_result->fetch_array(MYSQLI_ASSOC);

    return $row;
}