<?php
include_once "../../config.php";
$managerID = $_GET["managerID"];
$query = "select * from items where ManagerID='$managerID'";

$result = mysqli_query($db["conn"], $query);
$data = array();

while ($row = mysqli_fetch_array($result)) {
    array_push($data, array(
        'ID' => $row["ID"],
        'ItemName' => $row["ItemName"],
        'Price' => $row["Price"],
        'ImagePath' => $row["ImagePath"],
        'Des' => $row["Des"],
        'ManageID' => $row["ManagerID"]
    ));
}
mysqli_close($db["conn"]);
echo json_encode($data, JSON_UNESCAPED_UNICODE);
