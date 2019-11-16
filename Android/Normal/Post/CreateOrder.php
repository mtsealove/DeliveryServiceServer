<?php
include_once "../../config.php";
include_once "../../FCM.php";
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

mysqli_query($db["conn"], $query);

//FCM 발송
$tokenQuery="select Token from drivers where ManagerID='$ManagerID'";
$tokens=array();
$tokenResult=mysqli_query($db["conn"], $tokenQuery);
while($row=mysqli_fetch_assoc($tokenResult)) {
    $tokens[] = $row["Token"];
}

$arr = array();
$arr['title'] = "주문배달 서비스";
$arr['message'] = "새로운 주문이 있습니다";
$message_status = Driver_Push($tokens, $arr);

$managerTokenQuery="select Token from managers where ID='$ManagerID'";
$managerTokens=array();
$managerTokenResult=mysqli_query($db["conn"], $managerTokenQuery);
while($row=mysqli_fetch_assoc($managerTokenResult)) {
    $managerTokens[]=$row["Token"];
}
Manager_Push($managerTokens, $arr);

mysqli_close($db["conn"]);

$result = array(
    'Result' => 'Ok'
);
echo json_encode($result);