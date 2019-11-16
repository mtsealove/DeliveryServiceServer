<?php
include_once "../../config.php";
$id = $_GET["ID"];
$query = "select I.ItemName, I.Price as Price, I.ID, sum(I.price) as total, I.ImagePath from orders O
join Items I
on O.ItemID=I.ID
where O.managerID='$id'
group by ItemID
order by total desc
limit 6";
$result = mysqli_query($db["conn"], $query);

$data = array();
while ($row = mysqli_fetch_array($result)) {
    array_push($data, array(
        "ItemName"=>$row["ItemName"],
        "Price"=>$row["Price"],
        "Total"=>$row["total"],
        "ImagePath"=>$row["ImagePath"],
        "ID"=>$row["ID"]
    ));
 }
mysqli_close($db["conn"]);
 echo json_encode($data, JSON_UNESCAPED_UNICODE);