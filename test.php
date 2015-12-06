<html>
<body>
<p><span class="s1"></span><span class="s2"></span></p>
<script src="assets/js/jquery.min.js"></script>
<?php
/** curl post
   $ch = curl_init("http://localhost/newsPush.php");
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   $data = ["key" => "value"];
   curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
   $result = curl_exec($ch);
   curl_close($ch);
   var_dump($result);
 */

/** array count
   $arr = ["a" => "hello", "b" => "world"];
   echo count($arr);
 */

/** rand
   $i = 1000;
   while($i > 0) {
   $a = mt_rand(0, 10);
   echo $a, "\n";
   $i--;
   }
 */
for ($i = 0; $i < 10; $i++) {
    echo "<script>$('.s1').text($i); $('.s2').text('/10');</script>";
    ob_flush();
    flush();
    sleep(1);
}
echo "<script>$('p').text(10/10);</script>";
?>

</body>
</html>