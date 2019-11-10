<?php
include_once "../../config.php";
$ManagerID = $_POST["ManagerID"];
$MemberID = $_POST["MemberID"];
$OrderTime = $_POST["OrderTime"];
$Location = $_POST["Location"];
$ItemID = $_POST["ItemID"];

$query = "insert into orders(ItemID, managerid, memberid, ordertime, location, status)
values($ItemID, '$ManagerID', '$MemberID', '$OrderTime', '$Location', 0)";

$file=fopen("test.txt", "w");
fwrite($file, $query);
fclose($file);

mysqli_query($db["conn"], $query);
mysqli_close($db["conn"]);

$result = array(
    'Result' => 'Ok'
);
echo json_encode($result);
