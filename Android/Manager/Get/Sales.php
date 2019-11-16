<?php
include_once "../../config.php";

$id=$_GET["ID"];
$graphQuery = "select date_format(O.ordertime, '%Y-%m-%d') as orderdate, sum(I.Price) as total from orders O join 
 Items I on O.ItemID=I.ID
 where O.ManagerID='$id'
 group by date_format(ordertime, '%Y-%m-%d')
 order by orderdate desc
 limit 7";
$graphResult = mysqli_query($db["conn"], $graphQuery);

$data=array();
while($row=mysqli_fetch_array($graphResult)) {
    array_push($data, array(
        "OrderDate"=>$row["orderdate"],
        "Total"=>$row["total"]
    ));
}

mysqli_close($db["conn"]);
echo json_encode($data, JSON_UNESCAPED_UNICODE);