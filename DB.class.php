<?php

class DB extends PDO {
    public function __construct($file = "conf.ini") {
        $conf = parse_ini_file($file);
        $dns = sprintf("%s:host=%s;dbname=%s;port=%s",
                       $conf["type"],
                       $conf["host"],
                       $conf["dbname"],
                       $conf["port"]
        );
        parent::__construct($dns, $conf["user"], $conf["pass"]);
    }
}