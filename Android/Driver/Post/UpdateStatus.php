<?php
include_once "../../config.php";
//Call<Result> UpdateStatus(@Field("Status") int Status, @Field("OrderTime") String OrderTime, @Field("ManagerID") String managerID);
$status = $_POST["Status"];
$time = $_POST["OrderTime"];
$mangerID = $_POST["ManagerID"];
$driverID = $_POST["DriverID"];

$query = "update orders set status=$status, DriverID='$driverID' where managerID='$mangerID' and ordertime='$time'";



try {
    mysqli_query($db["conn"], $query);
    //배송 종료일 경우
    if ($status == 4) {
        $now = new DateTime();
        $compelteTime = $now->format('Y-m-d H:i:s');
        $timeQuery = "update orders set completeTime='$compelteTime' where managerID='$mangerID' and ordertime='$time'";
        mysqli_query($db["conn"], $timeQuery);
    }
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
