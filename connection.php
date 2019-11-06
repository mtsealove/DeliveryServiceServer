<?php
    //비밀번호는 파일로 저장
    $fs=fopen("pw.md5", "r");
    while(!feof($fs))
    $pw=fgets($fs);

     $db_id="DeliveryAdmin";
     $db_pw=$pw;
     $db_name="Delivery";
     $db_doamin="localhost";
     
     $db["conn"]=mysqli_connect($db_doamin, $db_id, $db_pw, $db_name);
?>