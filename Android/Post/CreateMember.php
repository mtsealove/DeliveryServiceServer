<?php
include_once "../../config.php";
$id = $_POST["ID"];
$name = $_POST["Name"];
$password = $_POST["Password"];

$query = "insert into members values('$id', '$password', '$name')";

try {
    mysqli_query($db["conn"], $query);
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
