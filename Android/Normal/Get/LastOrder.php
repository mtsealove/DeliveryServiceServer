<?php
//완료된 주문 조회
include_once "../../config.php";
$memeberID = $_GET["MemberID"];
$query = "select OO.OrderTime, OO.ItemName, OO.Price, MG.BusinessName from Managers MG join
(select O.OrderTime, O.ManagerID ,I.ItemName , O.MemberID, I.Price from orders O join items I
on O.ItemID=I.ID 
where MemberID='test' and status=4) OO
on MG.ID=OO.ManagerID;";

$data = array();

$result = mysqli_query($db["conn"], $query);
while ($row = mysqli_fetch_array($result)) {
    array_push($data, array(
        'OrderTime' => $row["OrderTime"],
        'ItemName' => $row["ItemName"],
        'Price' => $row["Price"],
        'BusinessName'=>$row["BusinessName"]
    ));
}

mysqli_close($db["conn"]);
echo json_encode($data, JSON_UNESCAPED_UNICODE);