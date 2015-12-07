<?php

require_once("source/conf/db.inc.php");

$title = $_POST["title"];
$time = time();
$tag = $_POST["tag"];
$img = $_POST["img"];
$content = $_POST["content"];
$url = $_POST["url"];

$dsn = DB_TYPE. ":host=". DB_HOST. ";dbname=". DB_DATA;
try {
$pdo = new PDO($dsn, DB_USER, DB_PASS);
$pdo->exec("set names utf8");
} catch (PDOException $e) {
    echo $e->getMessage();
}
$cidSql = "select cid from xycms_infocate where cname like '%行业%'";
$cids = $pdo->query($cidSql)->fetchAll(PDO::FETCH_NUM);
$cid = $cids[0][0];
$detail = '<p>'. $content. '<a href="'. $url. '">【详细】</a></p>';

$sql = "insert into xycms_info (cid, title, uploadfiles, content, timeline, flag, tag) values (?, ?, ?, ?, ?, ?, ?)";
$sth = $pdo->prepare($sql);
if ($sth->execute(array($cid, $title, $img, $detail, $time, 1, $tag))) {
    echo 1;
} else {
    echo 0;
}
