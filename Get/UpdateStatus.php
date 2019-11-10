<?php
include_once "../config.php";

if (empty($_SESSION["UserID"]) || empty($_SESSION["UserName"])) {
    echo "<script>
    alert('비정상적인 접근입니다');
    location.href='../Login.php';
    </script>";
}
$status = $_GET["status"];
$location = $_GET["location"];
$ordertime = $_GET["ordertime"];

$query = "update Orders set status={$status}
where ManagerID='" . $_SESSION["UserID"] .
    "' and OrderTime='{$ordertime}'
and Location='{$location}'";

echo $query; 

mysqli_query($db["conn"], $query);
mysqli_close($db["conn"]);


echo "<script>
alert('상태가 변경되었습니다');
location.href='../OrderList.php?current=2';
</script>";