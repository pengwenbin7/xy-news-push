<?php

require_once("DB.class.php");

$db = new DB();
$db->exec("set names utf8");

$domain = $_POST["domain"];
$keyword = $_POST["keyword"];

$sth = $db->prepare("insert into sites (domain, keyword) values (?, ?)");
if ($sth->execute([$domain, $keyword])) {
    echo 1;
} else {
    echo 0;
}