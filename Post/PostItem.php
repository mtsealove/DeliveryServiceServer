<?php
include_once "../config.php";

$upload_dir = '../Images/';

//파일 업로드
$file_name	 = $_FILES["img_file"]["name"];
$file_tmp_name = $_FILES["img_file"]["tmp_name"];
$file_type     = $_FILES["img_file"]["type"];
$file_size     = $_FILES["img_file"]["size"];
$file_error    = $_FILES["img_file"]["error"];

//데이터베이스
$ItemName=$_POST["ItemName"];
$Price=$_POST["Price"];

if ($file_name && !$file_error)
	{
		$file = explode(".", $file_name);

		$file_name="";
		for($j=0; $j<count($file)-1; $j++){
			$file_name=$file_name.$file[$j];
		}
		$file_ext=$file[count($file)-1];

		$new_file_name = date("Y_m_d_H_i_s");
		$new_file_name = $_SESSION["UserID"].$new_file_name;
		$copied_file_name = $new_file_name.".".$file_ext; 
        $uploaded_file = $upload_dir.$copied_file_name;
        echo $copied_file_name;

		if (!move_uploaded_file($file_tmp_name, $uploaded_file) )
		{
				echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1);
					</script>
				");
				exit;
		}
	}
	else 
	{
		$file_name      = "";
		$file_type      = "";
		$copied_file_name = "";
	}

    # ID, ItemName, Price, ManagerID, ImagePath

    //데이터베이스 조작
    $query="insert into items(ItemName, Price, ManagerID, ImagePath) values(
        '{$ItemName}', 
        '{$Price}', '"
        .$_SESSION['UserID']."', '"
        .$copied_file_name."')";

    mysqli_query($db["conn"], $query);
    mysqli_close($db["conn"]);
    
    echo "<script>
    alert('상품이 등록되었습니다');
    location.href='../ItemList.php?current=1'
    </script>";
?>