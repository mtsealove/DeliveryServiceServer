<!DOCTYPE html>
<html>

<head>
    <title>상품 등록</title>
    <?php include_once "head.php";
    include_once "config.php";
    if (empty($_SESSION["UserID"]) || empty($_SESSION["UserName"]) || empty($_GET["ItemID"])) {
        echo "<script>
        alert('비정상적인 접근입니다');
        location.href='Login.php'
        </script>";
    }

    $ItemID = $_GET["ItemID"];
    $ItemQuery = "select * from Items where ManagerID='" . $_SESSION["UserID"]
        . "' and ID={$ItemID}";

    $itemResult = mysqli_query($db["conn"], $ItemQuery);
    $row = mysqli_fetch_array($itemResult);
    mysqli_data_seek($itemResult, 0);
    mysqli_close($db["conn"]);
    $name = $row["ItemName"];
    $price = $row["Price"];
    $Des = $row["Des"];
    $path = $row["ImagePath"];
    ?>

    <script>
        $(function() {
            $('#edit_btn').click(function() {
                location.href="UpdateItem.php?current=1&ItemID=<?=$ItemID?>";
            });
        });

    </script>

</head>

<body>
    <?php
    include "nav.php"
    ?>
    <div class="content">
        <div class="bg-transpert signup_div center-block">
            <h3 class="card-title">상품 조회</h3>
            <h4 class="card-title"><?=$name?></h4>
            <p> 가격:  ₩<?=number_format($price)?></p>
            <p> 설명</p>
            <?=$Des?>
            <img id="item_img" width="90%" height="auto" src="./Images/<?=$path?>" class="rounded" />
            <button class="btn btn-block btn-primary" id="edit_btn">수정하기</button>
        </div>
    </div>
</body>

</html>