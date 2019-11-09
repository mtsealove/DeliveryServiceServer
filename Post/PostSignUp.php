<?php
include_once "../config.php";

$id = $_POST["id"];
$pw = $_POST["pw"];
$name = $_POST["name"];
$business_name = $_POST["business_name"];
$business_num = $_POST["business_num"];
$business_addr = $_POST["business_addr"];
$cat = $_POST["cat"];

//파일 업로드
$upload_dir = '../Images/';
$file_name     = $_FILES["img_file"]["name"];
$file_tmp_name = $_FILES["img_file"]["tmp_name"];
$file_type     = $_FILES["img_file"]["type"];
$file_size     = $_FILES["img_file"]["size"];
$file_error    = $_FILES["img_file"]["error"];

if ($file_name && !$file_error) {
    $file = explode(".", $file_name);

    $file_name = "";
    for ($j = 0; $j < count($file) - 1; $j++) {
        $file_name = $file_name . $file[$j];
    }
    $file_ext = $file[count($file) - 1];

    $new_file_name = "profile_".$id;
    $copied_file_name = $new_file_name . "." . $file_ext;
    $uploaded_file = $upload_dir . $copied_file_name;
    echo $copied_file_name;

    if (!move_uploaded_file($file_tmp_name, $uploaded_file)) {
        echo ("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1);
					</script>
				");
        exit;
    }
} else {
    $file_name      = "";
    $file_type      = "";
    $copied_file_name = "";
}


$query = "insert into Managers values('$id', '$pw', '$name', '$business_name', '$business_num', '$business_addr', $cat, null, '$copied_file_name')";
mysqli_query($db["conn"], $query);
mysqli_close($db["conn"]);

//로그인 페이지로 이동
echo "<script>
alert('회원가입이 완료되었습니다.');
location.href='../Login.php';
</script>";
