<?php

$mysqli = mysqli_connect("localhost", "root", "root");
mysqli_set_charset($mysqli, "utf8");
echo mysqli_query($mysqli, "create database testdb");

echo mysqli_query($mysqli, "create table testdb.t00 (id int(11) not null, site varchar(128), keyword varchar(64))");