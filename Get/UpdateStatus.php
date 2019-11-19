<?php
include_once "../config.php";
include_once "../Android/FCM.php";

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
mysqli_query($db["conn"], $query);

$tokens = array();
$tokenQuery = "select Token from Drivers where ManagerID='" . $_SESSION["UserID"] . "'";
$tokenResult = mysqli_query($db["conn"], $tokenQuery);

while ($row = mysqli_fetch_assoc($tokenResult)) {
    $tokens[] = $row["Token"];
}
$arr = array();
$arr['title'] = "주문배달 서비스";
$arr['message'] = "새로운 주문이 있습니다";

Driver_Push($tokens, $arr);

mysqli_close($db["conn"]);



echo "<script>
alert('상태가 변경되었습니다');
location.href='../OrderList.php?current=2';
</script>";
