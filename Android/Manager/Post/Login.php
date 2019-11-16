<?php
include_once "../../config.php";
$id = $_POST["ID"];
$pw = $_POST["Password"];
$token = $_POST["Token"];

$loginQuery = "select * from Managers where ID='$id' and password='$pw'";
$result = mysqli_query($db["conn"], $loginQuery);

//로그인 수행
if (mysqli_num_rows($result) != 0) {
    $row = mysqli_fetch_array($result);
    $data = array(
        "ID" => $row["ID"],
        "UserName" => $row["UserName"],
        "BusinessName" => $row["BusinessName"],
        "BusinessNum"=>$row["BusinessNum"],
        "BusinessAddress" => $row["BusinessAddress"],
        "ProfileImage" => $row["ProfileImage"]
    );
    echo json_encode($data, JSON_UNESCAPED_UNICODE);

    //토큰 업데이트
   $tokenQuery="update managers set token='$token' where ID='$id'";
   mysqli_query($db["conn"], $tokenQuery);
} else {
    $data = array(
        "ID" => null,
        "UserName" => null,
        "BusinessName" => null,
        "BusinessNum" => null,
        "BusinessAddress" => null,
        "ProfileImage" => null
    );
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}
mysqli_close($db["conn"]);