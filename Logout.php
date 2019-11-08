<?php
include_once "config.php";
unset($_SESSION["UserID"]);
unset($_SESSION["UserName"]);

setcookie("UserID", '', time() - 1);
setcookie("pw", '', time() - 1);
echo "<script>
location.href='Login.php';
</script>";
