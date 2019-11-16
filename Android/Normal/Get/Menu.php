<?php
include_once "../../config.php";
$ItemID = $_GET["ItemID"];
$query = "select * from items where ID=$ItemID";
$result = mysqli_query($db["conn"], $query);
$data = mysqli_fetch_array($result);
mysqli_close($db["conn"]);
echo json_encode($data, JSON_UNESCAPED_UNICODE);
