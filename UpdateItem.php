<!DOCTYPE html>
<html>

<head>
    <title>상품 등록</title>
    <?php include_once "head.php";
    include_once "config.php";
    if (empty($_SESSION["UserID"]) || empty($_SESSION["UserName"] || $_GET["ItemID"])) {
        echo "<script>
        alert('비정상적인 접근입니다');
        location.href='Login.php'
        </script>";
    }
    $itemID = $_GET["ItemID"];
    ?>

    <script>
        $(function() {
            $('#deny').hide();
            //$('#item_img').hide();
            //상품명 변경 시 중복확인
            $('#name_input').change(function() {
                CheckItemName();
            });
            //이미지 미리보기
            $('#file_input').change(function() {
                readURL(this);
            });
            //폼 submit
            $('#register_btn').click(function() {
                $('#upload_form').submit();
            });
        });

        function CheckItemName() {
            $.ajax({
                url: "./Ajax/ItemNameCheck.php",
                type: "post",
                data: {
                    ItemName: $('#name_input').val()
                },
                dataType: "json",
                success: function(data) {
                    //ID 사용 가능할 시 
                    if (data.check) {
                        $("#deny").fadeOut();
                    } else { //ID 사용 불가
                        $('#deny').fadeIn();
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        //화면에 이미지 표시
        function readURL(input) {
            $('#item_img').show();
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#item_img').attr('src', e.target.result);
                    $('#item_img').fadeIn();
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                $('#item_img').hide();
            }
        }
    </script>
</head>

<body>
    <?php
    include "nav.php"
    ?>
    <div class="content">
        <div class="bg-transpert signup_div center-block">
            <h3 class="card-title">상품 수정</h3>

            <?php
            $query = "select * from Items where ManagerID='" . $_SESSION["UserID"] . "' 
                and ID={$itemID}";
            $result = mysqli_query($db["conn"], $query);
            $row = mysqli_fetch_array($result);
            mysqli_data_seek($result, 0);
            $itemName = $row["ItemName"];
            $price = $row["Price"];
            $des = $row["Des"];
            $path = $row["ImagePath"];
            ?>

            <form enctype="multipart/form-data" method="POST" action="./Post/PostUpdateItem.php" id="upload_form">
                <input hidden name="ItemID" value="<?=$itemID?>">
                <input type="text" class="form-control" placeholder="상품명" id="name_input" name="ItemName" value="<?=$itemName?>" />
                <span id="deny" style="color:red">이미 사용중인 이름입니다</span>
                <br>
                <input type="number" class="form-control" placeholder="상품 금액" id="price_input" name="Price" value="<?=$price?>"/>
                <br>
                <textarea class="form-control rows=" 5" name="Des" placeholder="상품 설명" ><?=$des?></textarea>
                <br>
                <label>상품 이미지 선택</label>
                <input type="file" accept="image/*" class="form-control-file" placeholder="상품명" id="file_input" name="img_file" />
                <br>
            </form>
            <img id="item_img" width="90%" height="auto" src="./Images/<?=$path?>" class="rounded" />
            <button class="btn btn-block btn-success" id="register_btn">등록하기</button>
        </div>
    </div>
</body>

</html>