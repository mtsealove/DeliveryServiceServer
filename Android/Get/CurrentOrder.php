<?php
//현재 진행중인 주문 조회
include_once "../../config.php";
$MemberID = $_GET["MemberID"];
$query = "Select OO.*, SS.StatusName from 
(select O.OrderID,O.OrderTime, O.Location, I.ItemName, I.Price, I.ImagePath,O.status, O.currentLocation from orders O
join Items I
on I.ID=O.ItemID
where O.MemberID='$MemberID'
and status!=4) OO
join Status SS
on OO.status=SS.statusID
order by OO.OrderTime desc";

$result = mysqli_query($db["conn"], $query);
$data = array();

# OrderID, OrderTime, Location, ItemName, Price, ImagePath, status, StatusName


while ($row = mysqli_fetch_array($result)) {
    array_push($data, array(
        'OrderTime' => $row["OrderTime"],
        'Location' => $row["Location"],
        'currentLocation' => $row["currentLocation"],
        'ItemName' => $row["ItemName"],
        'Price' => $row["Price"],
        'ImagePath' => $row["ImagePath"],
        'StatusName' => $row["StatusName"]
    ));
}

mysqli_close($db["conn"]);
echo json_encode($data, JSON_UNESCAPED_UNICODE);