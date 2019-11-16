<?php
include_once "../../config.php";
$OrderID=$_GET["OrderID"];
$query="select * from Orders where OrderID=$OrderID";
$result=mysqli_query($db["conn"], $query);
$data=array();
while($row=mysql_fetch_array($result)) {
    array_push($data, array(
        "OrderTime"=>$row["OrderTime"],
        "Location"=>$row["Location"],
        "CurrentLocation"=>$row["CurrentLocation"]
    ));
}
echo json_encode($data, JSON_UNESCAPED_UNICODE);