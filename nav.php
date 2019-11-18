<!--상단 네비게이션-->
<?php
if (isset($_GET["current"])) {
  $current = $_GET["current"];
} else {
  echo "<script>
  alert('비정상적인 접근입니다');
  location.href='Login.php';
  </script>";
}
$classes = [];
for ($i = 0; $i < 5; $i++)
  $classes[$i] = 'nav-item';
$classes[$current] = 'nav-item active';
?>

<script>
  $(function() {
    $('#logout_btn').click(function() {
      if (confirm('로그아웃 하시겠습니까?')) {
        location.href = "Logout.php";
      }
    });
  });
</script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <img src="Src/delivery_logo.png" id="app_icon" height="40" width="40" style="margin-right:10px"/>
  <a class="navbar-brand" href="#">주문배달 서비스</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="<?= $classes[0] ?>">
        <a class="nav-link" href="index.php?current=0">Home
          <span class="sr-only">(current)</span></a>
      </li>
      <li class="<?= $classes[1] ?>">
        <a class="nav-link" href="ItemList.php?current=1">상품</a>
      </li>
      <li class="<?= $classes[2] ?>">
        <a class="nav-link" href="OrderList.php?current=2">주문</a>
      </li>
      <li class="<?= $classes[3] ?>">
        <a class="nav-link" href="Sales.php?current=3">매출</a>
      </li>

      <li class="<?= $classes[4] ?>">
        <a class="nav-link" href="Review.php?current=4">리뷰</a>
      </li>
    </ul>
    <!--
    <div>
    <button class="btn btn-link" id="logout_btn">로그아웃</button>
    </div>
-->
    <div class="btn-group dropleft">
      <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= $_SESSION["UserName"] ?>
      </button>
      <div class="dropdown-menu">
        <!-- Dropdown menu links -->
        <a class="dropdown-item" id="logout_btn">로그아웃</a>
      </div>
    </div>


  </div>
</nav>