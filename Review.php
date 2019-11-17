<!DOCTYPE html>
<html>

<head>
    <title>리뷰</title>
    <?php include_once "head.php";
    include_once "config.php";
    if (empty($_SESSION["UserID"]) || empty($_SESSION["UserName"]))
        echo "<script>alert('비정상적인 경로입니다');location.href='Login.php'</script>";
    ?>
</head>

<body>
    <?php
    include "nav.php"; ?>
    <div class="bg-transpert signup_div center-block">
        <h3 class="card-title">리뷰</h3>
        <?php
        $query = "select R.*, M.Name from Review R join Members M
        on R.MemberID=M.ID
        where ManagerID='".$_SESSION["UserID"]."'
        order by reviewtime desc";
        $result = mysqli_query($db["conn"], $query);
        while ($data = mysqli_fetch_array($result)) {
            ?>

            <div class="card">
                <div class="card-header">
                    <?=$data["Name"]?>
                </div>
                <div class="card-body">
                    <p class="card-text"><?=$data["Content"]?></p>
                    <span style="color:red; float:right"><?=$data["ReviewTime"]." 에 작성됨"?></span>
                </div>
            </div>
            <br>
        <?php } ?>
    </div>
</body>

</html>