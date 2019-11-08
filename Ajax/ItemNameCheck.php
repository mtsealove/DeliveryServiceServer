<?php
//이미 존재하는 상뭎명인지 확인
include_once "../config.php";
$ItemName = $_POST['ItemName'];
$query = "select ItemName from Items where ItemName='{$ItemName}'
and managerID='" . $_SESSION['UserID'] . "'";
$result = mysqli_query($db["conn"], $query);
$numOfRow = mysqli_num_rows($result);

if ($numOfRow == 0)
    $ret["check"] = true;
else $ret["check"] = false;

$res["check"]=true;
echo json_encode($ret);
?>