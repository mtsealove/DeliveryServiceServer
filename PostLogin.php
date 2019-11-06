<?php
    include_once "config.php";
    $ID=$_POST["ID"];
    $password=$_POST["password"];

    $sql="select ID, BusinessName from Managers where ID='$ID'
    and password='$password'";

    $result=mysqli_query($db["conn"], $sql);
    $numOfRow=mysqli_num_rows($result);

    if(!$numOfRow) {    //데이터가 존재하지 않는 경우
        echo "<script>alert('아이디와 비밀번호를 확인해주세요');history.go(-1);</script>";
    } else {
        //데이터 추출
        $row = mysqli_fetch_array($result);
        mysqli_data_seek($result, 0);
        mysqli_close($db["conn"]);
        //세션에 저장
        $_SESSION["UserID"]=$row["ID"];
        $_SESSION["UserName"]=$row["BusinessName"];
        
        //메인 페이지로 이동
        echo "<script>
        location.href='Home.php?current=0';
        </script>";
    }
?>