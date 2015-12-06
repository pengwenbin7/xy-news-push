<!doctype html>
<html>
  <head>
    <title>系统安装结果</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
    li {
      list-style-type: none;
    }
    .navbar li {
      float: left;
      margin-right: 15px;
    }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-bottom">
      <div class="container">
	<li><a class="home" href="/xy-news-push/index.php">首页</a></li>
	<li><a href="push.php">推送新闻</a></li>
	<li><a href="add.html">添加站点</a></li>
	<li><a href="log.html">查看日志</a></li>
      </div>
    </nav>
    <div class="container">
      <?php

      header("Content-type:text/html;charset=utf-8");
      $user = $_REQUEST["user"];
      $pass = $_REQUEST["pass"];
      $dbname = $_REQUEST["dbname"];

      $pdo = new PDO("mysql:host=localhost", $user, $pass);
      $sql = "create database IF NOT EXISTS $dbname CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'";
      $sth = $pdo->prepare($sql);
      if ($sth->execute()) {
	$sql = <<<SQL
DROP TABLE IF EXISTS $dbname.sites;
CREATE TABLE $dbname.sites (
`id` int(11) NOT NULL AUTO_INCREMENT,
`domain` varchar(128) NOT NULL,
`keyword` varchar(64) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
	$pdo->exec($sql);
	$conf = [
          "host" => "localhost",
            "type" => "mysql",
            "port" => 3306,
            "appkey" => "d4ffb3283c3a15154ab2215f995bf46e",
            "user" => $user,
            "pass" => $pass,
            "dbname" => $dbname,
	];
	save_ini($conf, "conf.ini");
	echo "初始化完成";
      } else {
	echo "创建数据库失败";
      }

      function save_ini($arr, $file) {
	$handle = fopen($file, "w");
	foreach ($arr as $key => $value) {
          fwrite($handle, "$key = $value". PHP_EOL);
	}
	fclose($handle);
      }
      ?>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
    var navas = $(".navbar a");
    navas.each(function(index) {
      if ($(this).href = location.href) {
	$(this).addClass("active");
      }
    });
    </script>
  </body>
</html>
