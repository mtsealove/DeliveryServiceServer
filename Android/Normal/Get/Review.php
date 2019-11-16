<?php
include_once "../../config.php";
$managerID = $_GET["ManagerID"];
$query = "select R.*, M.Name from Review R
join Members M
on R.MemberID=M.ID
where R.managerID='$managerID'
order by R.Reviewtime desc";

$result = mysqli_query($db["conn"], $query);
$data=array();
while ($row = mysqli_fetch_array($result)) { 
    array_push($data, array(
        "UserName"=>$row["Name"],
        "Content"=>$row["Content"],
        "Time"=>$row["ReviewTime"]
    ));
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);