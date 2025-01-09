<?php

/**
 * mysql連線
 * 資料庫函式
 */

class Database
{
    private $connection;

    public function __construct()
    {
        // 引入配置檔案
        $config = include(__DIR__ . '/../conf/db_config.php');

        // 使用配置檔案的資料庫資訊進行連線
        $this->connect($config);
    }

    private function connect($config)
    {
        $this->connection = new mysqli(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['dbname']
        );

        // 檢查連線是否成功
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // 通用的 query 方法，不帶參數
    public function query($sql)
    {
        $result = $this->connection->query($sql);

        if ($result === false) {
            echo "Error: " . $this->connection->error;
            return false;
        }

        return $result;
    }

    // prepare 方法用於準備帶參數的 SQL 語句
    public function prepare($sql)
    {
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            echo "Error in preparing statement: " . $this->connection->error;
            return false;
        }
        return $stmt;
    }

    function searchMemberByAccount($account)
    {
        $stmt = $this->prepare("SELECT * FROM member where account = ?");
        $stmt->bind_param("s", $account);
        $stmt->execute();
        $sql_result = $stmt->get_result();
        $row = $sql_result->fetch_array(MYSQLI_ASSOC);

        $stmt->close();
        return $row;
    }

    function searchMemberByUUID($uuid)
    {
        $stmt = $this->prepare("SELECT * FROM member where uuid = ? limit 1");
        $stmt->bind_param("s", $uuid);
        $stmt->execute();

        $sql_result = $stmt->get_result();
        $row = $sql_result->fetch_array(MYSQLI_ASSOC);

        $stmt->close();
        return $row;
    }

    // 資料庫斷開連接
    public function close()
    {
        $this->connection->close();
    }
}
