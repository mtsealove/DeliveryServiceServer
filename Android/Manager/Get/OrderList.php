<?php
include_once "../../config.php";
$id = $_GET["ID"];
$query = "Select OO.*, SS.StatusName from 
(select O.OrderID,O.OrderTime, O.Location, I.ItemName, I.Price, I.ImagePath,O.status from orders O
join Items I
on I.ID=O.ItemID
where O.managerID='$id'
and status!=4) OO
join Status SS
on OO.status=SS.statusID
order by OO.OrderTime asc
";

$result = mysqli_query($db["conn"], $query);
//# OrderID, OrderTime, Location, ItemName, Price, ImagePath, status, StatusName
$data = array();
while ($row = mysqli_fetch_array($result)) { 
    array_push($data, array(
        "OrderID"=>$row["OrderID"],
        "OrderTime"=>$row["OrderTime"],
        "Location"=>$row["Location"],
        "ItemName"=>$row["ItemName"],
        "Price"=>$row["Price"],
        "ImagePath"=>$row["ImagePath"],
        "status"=>$row["status"],
        "StatusName"=>$row["StatusName"]
    ));
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);