<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <title>推送新闻</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
    p {
      margin: 0;
    }
    .success {
      color: green;
    }
    .fail {
      color: red;
    }
    .well {
      padding: 0;
    }
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

      spl_autoload_register(function($class) {
	require_once($class. ".class.php");
      });

      $db = new DB();
      $db->exec("set names utf8");
      $fetch = $db->query("select count(id) from sites")->fetch(PDO::FETCH_NUM);
      $siteCount = $fetch[0][0];
      echo "<p>开始向", $siteCount, "个站点推送新闻</p>";

      $count = 0;
      $success = 0;
      $fail = 0;

      $sql = "select * from sites";
      $sth = $db->prepare($sql);
      $sth->execute();
      $sites = $sth->fetchAll(PDO::FETCH_ASSOC);

      foreach ($sites as $site) {
	$result = pushNews($site["domain"], $site["keyword"]);
	if ($result == 1) {
	  $success++;
	  echo '<p class="success">', "[$count]", '<span class="glyphicon glyphicon-ok-circle"></span>: ',
	    $site["domain"], " [", $site["keyword"], "]", "</p>";
	} else {
	  $fail++;
	  echo '<p class="fail">', "[$count]", '<span class="glyphicon glyphicon-remove-circle"></span>: ',
	    $site["domain"], " [", $site["keyword"], "] [", $result, "]</p>";
	}
	$count++;
	ob_flush();
	flush();
      }

      echo '<p class="well">', "向$count", "/", $siteCount, "个站点推送新闻，成功$success", "，失败$fail", "</p>";

      function pushNews($domain, $keyword) {
	$ch = curl_init("$domain/newsPush.php");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$json = getNews($keyword);
	$data = json_decode($json, true);
	if ($data["error_code"] == 0) {
	  $index = mt_rand(0, count($data["result"]) - 1);
	  $post = $data["result"][$index];
	  $post["tag"] = $keyword;
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	  $result = curl_exec($ch);
	  $errno = curl_errno($ch);
	  curl_close($ch);
	  if ($result != 1) {
	    return "url错误";
	  } else {
	    return $result;
	  }
	} else {
	  return $data["reason"];
	}
      }

      function getNews($keyword) {
	$query = urlencode($keyword);
	$conf =  parse_ini_file("conf.ini");
	$appKey = $conf["appkey"];

	$ch = curl_init("http://op.juhe.cn/onebox/news/query?key=$appKey&q=$query");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1 );
	$json = curl_exec($ch);
	curl_close($ch);
	return $json;
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
