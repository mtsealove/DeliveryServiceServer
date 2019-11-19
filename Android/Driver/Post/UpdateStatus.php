<?php
include_once "../../config.php";
include_once "../../FCM.php";
$status = $_POST["Status"];
$time = $_POST["OrderTime"];
$managerID = $_POST["ManagerID"];
$driverID = $_POST["DriverID"];

$query = "update orders set status=$status, DriverID='$driverID' where managerID='$managerID' and ordertime='$time'";

try {
    mysqli_query($db["conn"], $query);
    //배송 종료일 경우
    if ($status == 4) {
        $now = new DateTime();
        $compelteTime = $now->format('Y-m-d H:i:s');
        $timeQuery = "update orders set completeTime='$compelteTime' where managerID='$managerID' and ordertime='$time'";
        mysqli_query($db["conn"], $timeQuery);
    } 
    
    $tokenQuery = "select token from members where ID in(
        select distinct MemberID from orders where OrderTime='$time')";

    $tokenResult = mysqli_query($db["conn"], $tokenQuery);
    $tokens = array();
    while ($row = mysqli_fetch_assoc($tokenResult)) {
        $tokens[] = $row["token"];
    }

    $arr = array();
    $arr['title'] = "주문배달 서비스";
    switch($status){
        case 1:
            $arr['message'] = "주문 상태가 변경되었습니다(대기중)";
        break;
        case 2:
            $arr['message'] = "주문 상태가 변경되었습니다(준비중)";
        break;
        case 3:
            $arr['message'] = "주문 상태가 변경되었습니다(배송중)";
        break;
        case 4:
            $arr['message'] = "주문 상태가 변경되었습니다(배송 완료)";
        break;
    }
    Normal_Push($tokens, $arr);

    $result = array(
        "Result" => "Ok"
    );
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    $result = array(
        "Result" => "Fail"
    );
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} finally {
    mysqli_close($db["conn"]);
}
