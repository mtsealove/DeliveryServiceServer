<?php
include_once "config.php";
$id = $_POST["id"];
$pw = $_POST["pw"];
$name = $_POST["name"];
$business_name = $_POST["business_name"];
$business_num = $_POST["business_num"];
$business_addr = $_POST["business_addr"];
$cat = $_POST["cat"];

//데이터 삽입
$query = "insert into Managers values('$id', '$pw', '$name', '$business_name', '$business_num', '$business_addr', $cat)";
mysqli_query($db["conn"], $query);
mysqli_close($db["conn"]);
//로그인 페이지로 이동
echo "<script>location.href='Login.php'</script>";
