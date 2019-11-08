<!DOCTYPE html>
<html>

<head>
    <?php
    include_once "head.php";
    include_once "config.php";
    if (empty($_SESSION["UserID"]) || empty($_SESSION["UserName"]))
        echo "<script>alert('비정상적인 경로입니다');location.href='Login.php'</script>";
    ?>
    <title>배달주문 서비스</title>
</head>

<body>
    <?php include "nav.php"
    ?>

    <div class="bg-transpert main_div" style="padding:20px">

        <!--매출 요약-->
        <div class="row_fluid">
            <h3 class="card-title">매출</h3>
            <label style="float:right"><a>더보기</a></label>
            <div id="chart">
            </div>
        </div>
        <!--그래프 생성-->
        <?php
        $graphQuery = "select date_format(O.ordertime, '%Y-%m-%d') as orderdate, sum(I.Price) as total from orders O join 
        Items I on O.ItemID=I.ID
        where O.ManagerID='" . $_SESSION["UserID"] . "'
        group by date_format(ordertime, '%Y-%m-%d')
        order by orderdate desc
        limit 7";
        $graphResult = mysqli_query($db["conn"], $graphQuery);

        ?>

    <!--그래프 출력-->
        <script>
            var chart = bb.generate({
                data: {
                    x: "x",
                    columns: [
                        ["x"
                            <?php
                            while ($data = mysqli_fetch_array($graphResult)) {
                                $orderDate = $data["orderdate"];
                                echo ', "' . $orderDate.'"';
                            } ?>
                        ],
                        ["data1"
                            <?php 
                            $graphResult=mysqli_query($db["conn"],$graphQuery);
                            while ($data = mysqli_fetch_array($graphResult)) {
                                $total = $data["total"] / 1000;
                                echo "," . $total;
                            }
                            ?>
                        ],
                        ["data2"
                        <?php
                        $graphQuery="select date_format(ordertime, '%Y-%m-%d') as orderdate, count(*) as count
                        from orders
                        where managerID='".$_SESSION["UserID"]."'
                        group by orderdate";
                        $graphResult=mysqli_query($db["conn"], $graphQuery);
                        while($data=mysqli_fetch_array($graphResult)) {
                            $total=$data["count"];
                            echo ", ".$total;
                        }
                        ?>
                    ]
                    ],
                    types: {
                        data1: "area-spline",
                        data2: "area-spline"
                    },
                    colors: {
                        data1: "#A3A0FB",
                        data2: "#54D8FF"
                    },
                    names: {
                        data1: "매출(단위: 1000원)",
                        data2: "주문건수(단위: 1건)"
                    }
                },
                axis: {
                    x: {
                        type: "timeseries",
                        tick: {
                            count: 7,
                            format: "%Y-%m-%d"
                        }
                    }
                },
                area: {
                    lineGradient: true
                },

                bindto: "#chart"
            });
        </script>

        <div class="row-fluid">
            <h3 class="card-title pull-left">주요 상품</h3>
            <label style="float:right"><a href="ItemList.php?current=1">더보기</a></label>
        </div>

        <!--하단에 3개 표시될 주요 상품-->
        <div class="card-deck">

            <?php

            $query = "select I.ItemName, format(I.Price, 0) as Price, sum(I.price) as total from orders O
                join Items I
                on O.ItemID=I.ID
                where O.managerID='" . $_SESSION["UserID"] . "'
                group by ItemID
                order by price desc
                limit 6;";
            $result = mysqli_query($db["conn"], $query);

            $index = 0;
            while ($data = mysqli_fetch_array($result)) {
                $total = $data['total'];
                $price = $data['Price'];
                //카드 뷰 출력
                echo '  <div class="card">
                    <img class="card-img-top" src="./Images/americano.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">아메리카노</h5>
                        <p class="card-text">매출: ₩' . $total . '</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">상품가격: ₩' . $price . '</small>
                    </div>
                </div>';
            }
            mysqli_close($db["conn"]);
            ?>
        </div>
    </div>
</body>

</html>