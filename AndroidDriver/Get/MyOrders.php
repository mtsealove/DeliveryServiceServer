<?php
include_once "../../config.php";
$driverID=$_GET["DriverID"];
$query="select * from orders where DriverID='$driverID' and status!=1 and status!=4";

$result=mysqli_query($db["conn"], $query);
$data=array();
while($row=mysqli_fetch_array($result)) {
    array_push($data, array(
        "OrderTime"=>$row["OrderTime"],
        "Location"=>$row["Location"]
    ));
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);