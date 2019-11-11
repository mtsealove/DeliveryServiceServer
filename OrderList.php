<!DOCTYPE html>
<html>

<head>
    <title>주문</title>
    <?php
    include_once "head.php";
    include_once "config.php";
    if (empty($_SESSION["UserID"]) || empty($_SESSION["UserName"])) {
        echo "<script>
            alert('비정상적인 접근입니다');
            location.href='Login.php'
            </script>";
    }
    ?>

    <script>
    </script>
</head>

<body>
    <?php
    include "nav.php"; ?>

    <div class="bg-transpert main_div">
        <h3 class="card-title">주문</h3>


        <div class="order_div">
            <div class="card-deck order-card">
                <?php
                $orderQuery = "Select OO.*, SS.StatusName from 
                (select O.OrderID,O.OrderTime, O.Location, I.ItemName, I.Price, I.ImagePath,O.status from orders O
                join Items I
                on I.ID=O.ItemID
                where O.managerID='" . $_SESSION["UserID"] . "'
                and status!=4) OO
                join Status SS
                on OO.status=SS.statusID
                order by OO.OrderTime asc
                ";
                $orderResult = mysqli_query($db["conn"], $orderQuery);
                $numOfRow = mysqli_num_rows($orderResult);
                $lastTime = "";
                $lastLocation = "";
                $lastStatus = "";
                $isFirst = true;
                $index = 0;
                while ($data = mysqli_fetch_array($orderResult)) {
                    $index++;
                
                    //첫 데이터인지 확인
                    if ($isFirst) {
                        $lastTime = $data["OrderTime"];
                        $lastLocation = $data["Location"];
                        $lastStatus = $data["StatusName"];
                        $isFirst = false;
                    }

                    $orderTime = $data["OrderTime"];
                    $location = $data["Location"];
                    $path = $data["ImagePath"];
                    $itemName = $data["ItemName"];
                    $price = $data["Price"];
                    $status = $data["StatusName"];

                    //마지막인지 확인
                    if ($orderTime != $lastTime || $location != $lastLocation || $index > $numOfRow) {
                        //card 크기 조절
                        for($i=0;$i<4-$index; $i++) {
                            echo '<div class="card" style="visibility:hidden"></div>';
                        }
                        $index=0;
                        ?>
            </div>
            <div class="order-content-div">
                <p style="color:#19C1FF; margin-top:30px">주문시간: <?= substr($lastTime, 0, 16) ?></p>
                <p style="color:white">주소: <?= $lastLocation ?></p>
                <div class="btn-group">
                    <button class="btn btn-success btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $lastStatus ?></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="./Get/UpdateStatus.php?status=2&location=<?=$lastLocation?>&ordertime=<?=$lastTime?>">배송 준비중</a>
                        <a class="dropdown-item" href="./Get/UpdateStatus.php?status=3&location=<?=$lastLocation?>&ordertime=<?=$lastTime?>">배송중</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="order_div">
            <div class="card-deck order-card">

            <?php
                    $lastLocation = $location;
                    $lastTime = $orderTime;
                    $lastStatus = $status;
                } ?>
            <div class="card">
                <img class="card-img-top" src="./Images/<?= $path ?>" alt="Card image cap">
                <div style="padding:5px">
                    <p class="card-text"><?= $itemName ?></p>
                    <label><?= $price ?></label>
                </div>
            </div>

        <?php
        }
        for($i=0;$i<3-$index; $i++) {
            echo '<div class="card" style="visibility:hidden"></div>';
        }
        ?>
            </div>
            <div class="order-content-div">
                <p style="color:#19C1FF; margin-top:30px">주문시간: <?= substr($lastTime, 0, 16) ?></p>
                <p style="color:white">주소: <?= $lastLocation ?></p>
                <div class="btn-group">
                    <button class="btn btn-success btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $lastStatus ?></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="./Get/UpdateStatus.php?status=2&location=<?=$lastLocation?>&ordertime=<?=$lastTime?>">배송 준비중</a>
                        <a class="dropdown-item" href="./Get/UpdateStatus.php?status=3&location=<?=$lastLocation?>&ordertime=<?=$lastTime?>">배송중</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>

</html>