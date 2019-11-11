<?php
include_once "../../config.php";
$ManagerID = $_POST["ManagerID"];
$MemberID = $_POST["MemberID"];
$OrderTime = $_POST["OrderTime"];
$Location = $_POST["Location"];
$ItemID = $_POST["ItemID"];

//기본 위치를 가게로 설정
$locationQuery="select BusinessAddress from Managers where ID='$ManagerID'";
$result=mysqli_query($db["conn"], $locationQuery);
mysqli_data_seek($result, 0);
while($row=mysqli_fetch_array($result)) {
    $location=$row["BusinessAddress"];
}

//주문 삽입
$query = "insert into orders(ItemID, managerid, memberid, ordertime, location, status, CurrentLocation)
values($ItemID, '$ManagerID', '$MemberID', '$OrderTime', '$Location', 1, '$location')";

//최근 배송지 변경
$updateQuery="update members set RecentAddrss='$Location' where MemeberID='$MemberID'";
mysqli_query($db["conn"], $query);
mysqli_query($db["conn"], $updateQuery);
mysqli_close($db["conn"]);

$result = array(
    'Result' => 'Ok'
);
echo json_encode($result);
