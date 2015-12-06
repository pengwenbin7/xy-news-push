<?php

require_once("DB.class.php");

$id = $_GET["id"];
$db = new DB();
$sth = $db->prepare("delete from sites where id = $id");
if ($sth->execute()) {
    echo "删除成功";
} else {
    echo "删除失败";
}