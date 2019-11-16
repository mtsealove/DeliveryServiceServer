<?php
include_once "../../config.php";
$id = $_POST["ID"];
$password = $_POST["Password"];
$token = $_POST["Token"];

$query = "select ID, Name, ManagerID from drivers
where ID='$id'
and Password='$password'";

$result = mysqli_query($db["conn"], $query);
$numOfRow = mysqli_num_rows($result);
while ($row = mysqli_fetch_array($result)) {
    $Name = $row["Name"];
    $ID = $row["ID"];
    $ManagerID = $row["ManagerID"];
}


if ($numOfRow == 0) {
    $data = array(
        "ID" => null,
        "Name" => null,
        "ManagerID" => null
    );
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} else {
    $tokenQuery = "update Drivers set token='$token' where ID='$id'";
    mysqli_query($db["conn"], $tokenQuery);
    $data = array(
        "ID" => $ID,
        "Name" => $Name,
        "ManagerID" => $ManagerID
    );
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

mysqli_close($db["conn"]);
