<?php

header("Content-type:text/plain;charset=utf-8");

$dbname = $_GET["dbname"];
$user = $_GET["user"];
$pass = $_GET["pass"];

try {
    $pdo = new PDO("mysql:host=localhost", $user, $pass);
} catch(PDOException $e) {
    die("用户名或者密码错误");
}
$sth = $pdo->prepare("select SCHEMA_NAME from information_schema.SCHEMATA where SCHEMA_NAME = ?");
if ($sth->execute([$dbname])) {
    $fetch = $sth->fetch(PDO::FETCH_NUM);
    if ($fetch) {
        echo "数据库已存在";
    }
    else {
        echo 0;
    }
} else {
    echo "未知错误";
}