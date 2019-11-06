<?php
include_once "config.php";
$ID = $_POST["ID"];
$query = "select ID from Managers where ID='$ID'";
$result = mysqli_query($db["conn"], $query);
$numRow = mysqli_num_rows($result);
if ($numRow == 0) {
    $ret["check"] = true;
} else {
    $ret["check"] = false;
}

echo json_encode($ret);
