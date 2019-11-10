<!DOCTYPE html>
<html>

<head>
    <title>매출</title>
    <?php include_once "head.php";
    include_once "config.php";
    ?>
</head>

<body>
    <?php include "nav.php" ?>

    <div class="bg-transpert main_div">
        <h3 class="card-title">매출</h3>
        <div id="chart">
        </div>
        <label>최근 1달</label>
        <!--그래프 생성-->
        <?php
        $graphQuery = "select date_format(O.ordertime, '%Y-%m-%d') as orderdate, sum(I.Price) as total from orders O join 
        Items I on O.ItemID=I.ID
        where O.ManagerID='" . $_SESSION["UserID"] . "'
        group by date_format(ordertime, '%Y-%m-%d')
        order by orderdate desc
        limit 30";
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
                                echo ', "' . $orderDate . '"';
                            } ?>
                        ],
                        ["data1"
                            <?php
                            $graphResult = mysqli_query($db["conn"], $graphQuery);
                            while ($data = mysqli_fetch_array($graphResult)) {
                                $total = $data["total"] / 1000;
                                echo "," . $total;
                            }
                            ?>
                        ],
                        ["data2"
                            <?php
                            $graphQuery = "select date_format(ordertime, '%Y-%m-%d') as orderdate, count(*) as count
                        from orders
                        where managerID='" . $_SESSION["UserID"] . "'
                        group by orderdate";
                            $graphResult = mysqli_query($db["conn"], $graphQuery);
                            while ($data = mysqli_fetch_array($graphResult)) {
                                $total = $data["count"];
                                echo ", " . $total;
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
                        data1: "매출(단위: 1,000원)",
                        data2: "주문건수(단위: 1건)"
                    }
                },
                axis: {
                    x: {
                        type: "timeseries",
                        tick: {
                            count: 30,
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
    </div>
    <?php

    $saleQuery = "select II.*, TT.total from Items II join
(select I.ID as ID, sum(I.price) as total from orders O
join Items I
on O.ItemID=I.ID
group by ID
order by price desc) TT
on II.ID=TT.ID
where ManagerID='" . $_SESSION["UserID"] . "'
order by total desc";
    $saleResult = mysqli_query($db["conn"], $saleQuery);
    ?>
    <div class="bg-transpert main_div">
        <h3 class="card-title">판매량 순위</h3>
        <div>
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>순위</th>
                        <th>상품명</th>
                        <th>가격</th>
                        <th>매출</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 0;
                    while ($data = mysqli_fetch_array($saleResult)) {
                        $index++;
                        $itemName = $data["ItemName"];
                        $price = $data["Price"];
                        $total = $data["total"]; ?>

                        <tr>
                            <td><?= $index ?></td>
                            <td><?= $itemName ?></td>
                            <td>₩<?= number_format($price) ?></td>
                            <td>₩<?= number_format($total) ?></td>
                        </tr>
                    <?php }
                    mysqli_close($db["conn"]);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>