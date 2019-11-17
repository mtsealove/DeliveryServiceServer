<?php
include_once "../../config.php";
$OrderID = $_GET["OrderID"];
$query = "select * from orders O join Status S
on O.status=S.statusID where orderID=$OrderID;";
$result = mysqli_query($db["conn"], $query);

while ($row = mysqli_fetch_array($result)) {
    $data=array(
        "OrderTime" => $row["OrderTime"],
        "Location" => $row["Location"],
        "CurrentLocation" => $row["CurrentLocation"],
        "StatusName"=>$row["StatusName"]
    );
}
echo json_encode($data, JSON_UNESCAPED_UNICODE);
