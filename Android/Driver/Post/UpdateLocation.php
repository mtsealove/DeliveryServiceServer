<?php
include_once "../../config.php";

$driverID=$_POST["DriverID"];
$location=$_POST["Location"];
$query="update orders set CurrentLocation='$location' where DriverID='$driverID' and status!=1 and status!=4";
try {
    mysqli_query($db["conn"], $query);
    $result=array(
        "Result"=>"Ok"
    );
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch(Exception $e) {
    $result=array(
        "Result"=>"Fail"
    );
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} finally {
    mysqli_close($db["conn"]);
}