<?php
include_once "../../config.php";
$id = $_POST["ID"];
$query="select ID from members where ID='$id'";

$result = mysqli_query($db["conn"], $query);
$numOfRow = mysqli_num_rows($result);
//회원가입 ID존재하는지 확인
if ($numOfRow != 0) {
    $exist = array(
        "Exist" => true
    );
    echo json_encode($exist, JSON_UNESCAPED_UNICODE);
} else {
    $exist = array(
        "Exist" => false
    );
    echo json_encode($exist, JSON_UNESCAPED_UNICODE);
}
