<?php
include_once "../../config.php";
$id = $_GET["ManagerID"];
$query = "select R.*, M.Name from review R join Members M
on R.MemberID=M.id
where R.managerID='$id' order by R.ReviewTime desc";

$result = mysqli_query($db["conn"], $query);
$data = array();

while ($row = mysqli_fetch_array($result)) { 
    array_push($data, array(
        "ReviewTime"=>$row["ReviewTime"],
        "Content"=>$row["Content"],
        "Name"=>$row["Name"]
    ));
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);