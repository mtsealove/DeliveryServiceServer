<?php
include_once "../../config.php";
$cat = $_GET["Cat"];
$query = "select ID, BusinessName, BusinessAddress, Category, ProfileImage
from Managers
where Category=$cat";

$result = mysqli_query($db["conn"], $query);

$data = array();

while ($row = mysqli_fetch_array($result)) {
    array_push($data, array(
        'ID' => $row["ID"],
        'BusinessName' => $row["BusinessName"],
        'BusinessAddress' => $row["BusinessAddress"],
        'Category' => $row["Category"],
        'ProfileImage' => $row["ProfileImage"]
    ));
}
mysqli_close($db["conn"]);
echo json_encode($data, JSON_UNESCAPED_UNICODE);
