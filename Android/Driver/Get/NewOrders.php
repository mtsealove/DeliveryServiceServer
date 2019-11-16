<?php
include_once "../../config.php";
$managerID = $_GET["ManagerID"];
$query = "select * from orders where ManagerID='$managerID' and status=2 order by orderTime desc";
$result = mysqli_query($db["conn"], $query);
$data = array();
while ($row = mysqli_fetch_array($result)) {
    array_push($data, array(
        "OrderTime" => $row["OrderTime"],
        "Location" => $row["Location"],
        "OrderID"=>$row["OrderID"]
    ));
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
