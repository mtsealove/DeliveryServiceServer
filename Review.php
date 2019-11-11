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
    include "nav.php";
    
    $query="select * from Review where ManagerID='".$_SESSION["UserID"]."'";
    $result=mysqli_query($db["conn"], $query);
    while($data=mysqli_fetch_array($result)) {
    ?>

    <?php } ?>
</body>

</html>