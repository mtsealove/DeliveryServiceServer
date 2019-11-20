<?php
include_once "config.php";
unset($_SESSION["UserID"]);
unset($_SESSION["UserName"]);

echo "<script>
location.href='Login.php';
</script>";
