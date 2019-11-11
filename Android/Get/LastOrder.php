<?php
//완료된 주문 조회
include_once "../../config.php";
$memeberID = $_GET["MemberID"];
$query = "(select O.OrderID,O.OrderTime, O.Location, I.ItemName, I.Price, I.ImagePath,O.status, O.currentLocation from orders O
join Items I
on I.ID=O.ItemID
where O.MemberID='$memeberID'
and status=4) OO
join Status SS
on OO.status=SS.statusID
order by OO.OrderTime asc";

$data = array();

$result = mysqli_query($db["conn"], $query);
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