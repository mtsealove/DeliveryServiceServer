<?php
include_once "../../config.php";

$id = $_POST["ID"];
$password = $_POST["Password"];

//# ID, passwored, DefaultAddress, RecentAddress
$query = "select ID, name from members where ID='$id' and password='$password'";

$result = mysqli_query($db["conn"], $query);

//로그인 실패
if (mysqli_num_rows($result) == 0) {
    $fail = array(
        "ID" => null,
        "Name" => null
    );
    echo json_encode($fail, JSON_UNESCAPED_UNICODE);
} else {    //로그인 성공
    mysqli_data_seek($result, 0);
    $row=mysqli_fetch_array($result);
    $success=array(
        "ID"=>$row["ID"],
        "Name"=>$row["name"]
    );
    echo json_encode($success, JSON_UNESCAPED_UNICODE);
}
