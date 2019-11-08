<!DOCTYPE html>
<html>

<head>
    
    <title>배달주문 서비스 - 로그인</title>
    <?php
    include "head.php";
    include_once "config.php";
    if(isset($_SESSION["UserID"])&&isset($_SESSION["UserName"])) {
        echo "<script>
        location.href='Home.php?current=0'
        </script>";
    }
    ?>

    <script>
        //입력 값 체크
        $(function() {
            $('#login_btn').click(function(){
                CheckInput();
            });
            //비밀번호 란에서 엔터 클릭 시 작업
            $('#pw_input').keydown(function(key){
                if(key.keyCode==13){
                    CheckInput();
                }
            })
        });
        //문자열 입력 체크
        function CheckInput() {
            if($('#id_input').val()==''){
                alert('아이디를 입력하세요');
            } else if($('#pw_input').val()=='') {
                alert('비밀번호를 입력하세요');
            } else {
                $('#login_form').submit();
            }
        }
    </script>
</head>

<body>
    <div class="content">
        <div class="bg-transpert center-block login_div">
            <h3 class="card-title">로그인</h3>

            <form id="login_form" action="./Post/PostLogin.php" method="POST">
                <input type="text" name="ID" placeholder="ID" class="form-control" id="id_input"><br>
                <input type="password" name="password" placeholder="Password" class="form-control" id="pw_input"><br>
            </form>

            <button type="button" id="login_btn" class="btn btn-block btn-success">로그인</button>

            <br>
            <div style="text-align:center">
                <label><a href="SignUp.php">회원가입&nbsp;&nbsp;</a></label>
                <label>&nbsp;&nbsp;ID/비밀번호 찾기</label>
            </div>
        </div>
    </div>
</body>

</html>