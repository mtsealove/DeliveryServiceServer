<?php
include_once "../../config.php";
$ManagerID = $_POST["ManagerID"];
$MemberID = $_POST["MemberID"];
$OrderTime = $_POST["OrderTime"];
$Location = $_POST["Location"];
$ItemID = $_POST["ItemID"];

//기본 위치를 가게로 설정
$locationQuery="select BusinessAddress from Managers where ID='$ManagerID'";
$result=mysqli_query($db["conn"], $locationQuery);
mysqli_data_seek($result, 0);
while($row=mysqli_fetch_array($result)) {
    $location=$row["BusinessAddress"];
}

//주문 삽입
$query = "insert into orders(ItemID, managerid, memberid, ordertime, location, status, CurrentLocation)
values($ItemID, '$ManagerID', '$MemberID', '$OrderTime', '$Location', 1, '$location')";

mysqli_query($db["conn"], $query);

//FCM 발송
$tokenQuery="select Token from drivers where ManagerID='$ManagerID'";
$tokens=array();
$tokenResult=mysqli_query($db["conn"], $tokenQuery);
while($row=mysqli_fetch_assoc($tokenResult)) {
    $tokens[] = $row["Token"];
}

$arr = array();
$arr['title'] = "주문배달 서비스";
$arr['message'] = "새로운 주문이 있습니다";
$message_status = Android_Push($tokens, $arr);

mysqli_close($db["conn"]);

$result = array(
    'Result' => 'Ok'
);
echo json_encode($result);


function Android_Push($tokens, $message) {
    $url = 'https://fcm.googleapis.com/fcm/send';
    $apiKey = "AAAA1sTifQ8:APA91bEbbE3NxvqMNZF79ptDCz1L07Pi9e40v6TWDqa8JAtTkwl2Fh81PhBOi0Ou4YllbRuOhQ04A8ByuaGzhm33xyMv0tBEW90CpTn_bPs-QcZUUzWi5gMx74uUH_O0YPPz-aKn7738";

    $fields = array('registration_ids' => $tokens,'data' => $message);
    $headers = array('Authorization:key='.$apiKey,'Content-Type: application/json');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}