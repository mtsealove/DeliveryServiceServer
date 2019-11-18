<?php /* 클래스 파일 로드 */
include "Sendmail.php";
include_once "../config.php";

$config = array(
    'host' => 'ssl://smtp.gmail.com',
    'smtp_id' => 'mtsealove0927@gmail.com',
    'smtp_pw' => 'mphrxvmqufrwvong',
    'debug' => 1,
    'charset' => 'utf-8',
    'ctype' => 'text/plain'
);
$sendmail = new Sendmail($config);

$str="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
$str=str_split($str);
$code = "";
for($i=0; $i<16; $i++) {
    $index=mt_rand(0, count($str)-1);
    $code=$code.$str[$index];
}

$to = $_POST["mail"];
$from = "주문배달 서비스";
$subject = "비밀번호 재설정 인증번호입니다";
$body = "주문배달 서비스 비밀번호 재설정 인증번호는 ".$code." 입니다";

/* 메일 보내기 */
$existQuery = "select ID from managers where ID='$to'";
$result = mysqli_query($db["conn"], $existQuery);
$numOfRow = mysqli_num_rows($result);
if ($numOfRow) {
    $sendmail->send_mail($to, $from, $subject, $body);
    $ret["complete"] = true;
    $ret["code"]=$code;
    echo json_encode($ret);
    
} else {
    $ret["complete"] = false;
    echo json_encode($ret);
}
