<!--상단 네비게이션-->
<?php
  $current=$_GET["current"];
  $classes=[];
  for($i=0; $i<4; $i++) 
  $classes[$i]='nav-item';
  $classes[$current]='nav-item active';
?>

<script>
  $(function() {
    $('#logout_btn').click(function() {
      if(confirm('로그아웃 하시겠습니까?')) {
        location.href="Logout.php";
      }
    });
  });
  </script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">배달주문 서비스</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="<?=$classes[0]?>">
        <a class="nav-link" href="Home.php?current=0">Home
          <span class="sr-only">(current)</span></a>
      </li>
      <li class="<?=$classes[1]?>">
        <a class="nav-link" href="ItemList.php?current=1">상품</a>
      </li>
      <li class="<?=$classes[2]?>">
        <a class="nav-link" href="/Company">주문</a>
      </li>
      <li class="<?=$classes[3]?>">
        <a class="nav-link" href="/Contact">매출</a>
      </li>
    </ul>
    <button class="btn btn-link" id="logout_btn">로그아웃</button>
  </div>
</nav>