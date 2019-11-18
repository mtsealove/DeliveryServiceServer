<!DOCTYPE html>
<html>

<head>
    <title>상품</title>
    <?php
    include_once "head.php";
    include_once "config.php";

    if (empty($_SESSION["UserID"]) || empty($_SESSION["UserName"])) {
        echo "<script>
        alert('비정상적인 접근입니다');
        location.href='Login.php'
        </script>";
    }
    if (empty($_GET["sort"]))
        $sort = "total desc";
    else
        $sort = $_GET["sort"];
    ?>

    <script>
        //상품 등록 페이지로 이동
        $(function() {
            $('#register_btn').click(function() {
                location.href = "RegisterItem.php?current=1";
            });
        });
    </script>
</head>

<body>
    <?php
    include "nav.php";
    if (empty($_GET["page"])) {
        $page = 0;
    } else {
        $page = $_GET["page"];
    }
    $sep = 6;
    $start = 0;
    ?>


    <div class="bg-transpert main_div">
        <div>
            <h3 class="card-title">상품</h3>
            <!--상품 정렬기준-->
            <div class="btn-group">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    정렬기준
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="?sort=total desc&current=1">매출 많은순</a>
                    <a class="dropdown-item" href="?sort=total asc&current=1">매출 적은순</a>
                    <a class="dropdown-item" href="?sort=ItemName asc&current=1">이름 오름차순</a>
                    <a class="dropdown-item" href="?sort=ItemName desc&current=1">이름 내림차순</a>
                    <a class="dropdown-item" href="?sort=Price desc&current=1">가격 높은순</a>
                    <a class="dropdown-item" href="?sort=Price asc&current=1">가격 낮은순</a>
                </div>
            </div>
        </div>

        <?php
        for ($row = 0; $row < 2; $row++) {
            $start = ($page * 2 + $row) * $sep;
            ?>
            <div class="card-deck">
                <?php
                    include_once "config.php";
                    $query = "select II.*, TT.total from Items II left outer join
            (select I.ID as ID, sum(I.price) as total from orders O
            join Items I
            on O.ItemID=I.ID
            group by ID
            order by price desc) TT
            on II.ID=TT.ID
            where ManagerID='" . $_SESSION["UserID"] . "'
            order by {$sort}
            limit {$start}, 6";
                    $result = mysqli_query($db["conn"], $query);

                    $index = 0;
                    while ($data = mysqli_fetch_array($result)) {
                        $total = $data['total'];
                        $price = $data['Price'];
                        $path = $data['ImagePath'];
                        $ItemName = $data["ItemName"];
                        $itemID = $data["ID"];
                        $index++;

                        //카드 뷰 출력
                        ?>
                    <div class="card" onclick="location.href='InquireItem.php?current=2&ItemID=<?= $itemID ?>'">
                        <img class="card-img-top" height="180" src="./Images/<?= $path ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?= $ItemName ?></h5>
                            <p class="card-text">매출: ₩<?= number_format($total) ?></p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">상품가격: ₩<?= number_format($price) ?></small>
                        </div>
                    </div>
                <?php  }
                    for ($i = 0; $i < 6 - $index; $i++) {
                        echo '<div class="card" style="visibility:hidden"></div>';
                    }
                    ?>
            </div>
            <br>
        <?php } ?>
        <div>
            <!--pagination-->
            <?php
            if ($page == 0) {
                $privious = "disabled";
            } else {
                $privious = "";
            }


            $pageQuery = "select count(*) cnt from Items where ManagerID='" . $_SESSION['UserID'] . "'";
            $pageResult = mysqli_query($db["conn"], $pageQuery);
            while ($data = mysqli_fetch_array($pageResult)) {
                $count = $data['cnt'];
            }
            
            $total_page = ceil($count / ($sep * 2));

            if ($total_page <= $page+1) {
                $next = "disabled";
            } else $next = "";
            ?>

            <nav>
                <ul class="pagination">
                    <li class="page-item <?= $privious ?>">
                        <a class="page-link" href="?current=1&page=<?= $page - 1 ?>&sort=<?= $sort ?>" tabindex="-1">이전</a>
                    </li>
                    <?php
                    $big=floor($total_page/10);
                    for ($p = 10*$big; $p < 10*$big+10; $p++) {
                        //현재 페이지
                        if($p*12>$count) break;
                        if ($page == $p) { ?>
                            <li class="page-item active">
                                <a class="page-link" href="#"><?= $page + 1 ?> <span class="sr-only">(current)</span></a>
                            </li>
                        <?php
                            } else {
                                ?>
                            <li class="page-item"><a class="page-link" href="?current=1&sort=<?= $sort ?>&page=<?= $p ?>"><?= $p + 1 ?></a></li>
                    <?php
                        }
                    }
                    ?>

                    <li class="page-item  <?= $next ?>"">
                        <a class=" page-link" href="?current=1&page=<?= $page + 1 ?>&sort=<?= $sort ?>">다음</a>
                    </li>
                </ul>
            </nav>
            <button id="register_btn" class="btn btn-primary" style="float:right; margin-top:-55px">등록하기</button>
            <div>
            </div>
</body>

</html>