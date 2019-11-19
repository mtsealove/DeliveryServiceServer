<?php
include_once "../../config.php";
include_once "../../FCM.php";
$managerID = $_POST["ManagerID"];
$OrderTime = $_POST["OrderTime"];
$status = $_POST["Status"];

$query = "update orders set status=$status
where OrderTime='$OrderTime'
and ManagerID='$managerID'";

try {
    mysqli_query($db["conn"], $query);
    $memberQuery = "select MemberID from orders where OrderTime='$OrderTime' and ManagerID='$managerID'";
    $memberResult = mysqli_query($db["conn"], $memberQuery);
    $memberID="";

    
    while ($row = mysqli_fetch_array($memberResult)) {
        $memberID = $row["MemberID"];
    }

    $tokenQuery = "select token from Members where ID='$memberID'";
    $tokenResult = mysqli_query($db["conn"], $tokenQuery);
    $tokens = array();
    while ($row = mysqli_fetch_assoc($tokenResult)) {
        $tokens[] = $row["token"];
    }

    $arr = array();
    $arr['title'] = "주문배달 서비스";
    $arr['message'] = "주문 상태가 변경되었습니다";
    $message_status = Normal_Push($tokens, $arr);

    $result = array(
        "Result" => "Ok"
    );
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    $result = array(
        "Result" => "Fail"
    );
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}

mysqli_close($db["conn"]);
