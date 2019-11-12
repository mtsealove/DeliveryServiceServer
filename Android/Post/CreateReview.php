<?php
include_once "../../config.php";
$memeberID = $_POST["MemberID"];
$managerID = $_POST["ManagerID"];
$content = $_POST["Content"];
$now = new DateTime();
$reviewTime = $now->format('Y-m-d H:i:s');

$query = "insert into review 
set ManagerID='$managerID',
MemberID='$memeberID',
Content='$content',
ReviewTime='$reviewTime'";

try {
    $result = mysqli_query($db["conn"], $query);

    $res = array(
        "Result" => "Ok"
    );
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    $res = array(
        "Result" => "Fail"
    );
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
} finally {
    mysqli_close($db["conn"]);
}
