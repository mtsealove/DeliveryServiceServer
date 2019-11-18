<?php
include_once "../config.php";
$id=$_POST["ID"];
$pw=$_POST["Password"];

$query="update managers set password='$pw' where ID='$id'";
try{
    mysqli_query($db["conn"], $query);
    $result["result"]=true;
    echo json_encode($result);
} catch(Exception $e){
    $result["result"]=false;
    echo json_encode($result);
} finally{
    mysqli_close($db["conn"]);
}