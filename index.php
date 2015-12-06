<!doctype html>
<html>
  <head>
    <title>首页</title>
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
	<li><a class="home" href="/news-push/index.php">首页</a></li>
	<li><a href="push.php">推送新闻</a></li>
	<li><a href="add.html">添加站点</a></li>
	<li><a href="log.html">查看日志</a></li>
      </div>
    </nav>
    <div class="container">
      <?php

      spl_autoload_register(function($class) {
	require_once($class. ".class.php");
      });

      if (!file_exists("conf.ini")) {
	echo "<p>程序未初始化，马上开始初始化",
          '<a href="install.html"><button>确定</button></a></p>';
	exit;
      }

      echo "<p>当前站点：</p>";
      $db = new DB();
      $db->exec("set names utf8");
      $sth = $db->prepare("select * from sites");
      if ($sth->execute()) {
	$sites = $sth->fetchAll(PDO::FETCH_ASSOC);
	foreach ($sites as $site) {
          echo '<li class="site">', $site["id"],
            ': <a href="', $site["domain"],
	    '">', $site["domain"], "</a>",
            "[", $site["keyword"], "]</li>";
	}
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
