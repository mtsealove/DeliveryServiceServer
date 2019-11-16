<!DOCTYPE html>
<html>

<head>
    <title>회원가입</title>
    <?php
    include_once "config.php";
    include_once "head.php";
    //카테고리 리스트 출력
    $sql = "select * from Category";
    $result = mysqli_query($db["conn"], $sql);
    ?>

    <script>
        $(function() {
            $('#sign_up_btn').click(function() {
                CheckInput();
            });

            $('#id_deny').hide();
            $('#id_allow').hide();
            $('#pw_deny').hide();
            $('#pw_allow').hide();
            $('#pw_dif').hide();
            $('#pw_same').hide();

            $('#id_input').change(function() {
                CheckIDAllow();
            });
            $('#pw_input').change(function() {
                if (CheckPassword()) {
                    $('#pw_deny').hide();
                    $('#pw_allow').show();
                } else {
                    $('#pw_deny').show();
                    $('#pw_allow').hide();
                }
            });
            $('#pw_confirm_input').change(function() {
                if (SamePassword()) {
                    $('#pw_dif').hide();
                    $('#pw_same').show();
                } else {
                    $('#pw_dif').show();
                    $('#pw_same').hide();
                }
            })
        });

        function CheckInput() {
            if ($('#id_input').val() == '') {
                alert('ID를 입력하세요');
                $('#id_input').focus();
                return;
            } else if ($('#pw_input').val() == '') {
                alert('비밀번호를 입력하세요');
                $('#pw_input').focus();
                return;
            } else if ($('#pw_input').val().length < 8) {
                alert('비밀번호는 8자리 이상이여야 합니다');
                $('#pw_input').focus();
                return;
            } else if ($('#pw_confirm_input').val() == '') {
                alert('비밀번호를 확인하세요');
                $('#pw_confirm_input').focus();
                return;
            } else if ($('#pw_input').val() != $('#pw_confirm_input').val()) {
                alert('비밀번호가 일치하지 않습니다');
                $('#pw_confirm_input').focus();
                return;
            } else if ($('#name_input').val() == '') {
                alert('이름을 입력하세요');
                $('#name_input').focus();
                return;
            } else if ($('#business_name_input').val() == '') {
                alert('사업장명을 입력하세요');
                $('#business_name_input').focus();
                return;
            } else if ($('#business_num_input').val() == '') {
                alert('사업자번호를 입력하세요');
                $('#business_num_input').focus();
                return;
            } else if ($('business_addr_input').val() == '') {
                alert('사업장 주소를 입력하세요');
                $('#business_addr_input').focus();
                return;
            } else if ($('#id_check').attr('data-check') == 0) {
                $('#id_deny').show();
                $('#id_input').focus();
                return;
            } else if ($('#pw_check').attr('data-check') == 0) {
                $('#pw_deny').show();
                $('#pw_input').focus();
                return;
            } else if ($('#cat_select').val() == 0) {
                alert('상품 분류를 선택하세요');
                $('#cat_select').focus();
            } else {
                $('#sign_up_form').submit();
            }
        }

        function CheckPassword() {
            var password = $('#pw_input').val();
            var lowerB = false;
            var upperB = false;
            var specialB = false;

            var lower = "abcdefghijklmnopqrstuvwxyz";
            var upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            var special = "!@#$%^&*()_+-=,./<>[]{}";

            for (var i = 0; i < lower.length; i++) {
                if (password.indexOf(lower.charAt(i))) {
                    lowerB = true;
                    break;
                }
            }
            for (var i = 0; i < upper.length; i++) {
                if (password.indexOf(upper.charAt(i))) {
                    upperB = true;
                    break;
                }
            }
            for (var i = 0; i < special.length; i++) {
                if (password.indexOf(special.charAt(i))) {
                    specialB = true;
                    break;
                }
            }

            if (lowerB && upperB && specialB && password.length > 8){
                $('#pw_check').attr('data-check', '1');
                return true;
            } else{
                $('#pw_check').attr('data-check', '0');
                return false;
            } 
        }

        function SamePassword() {
            var pw = $('#pw_input').val();
            var pw_confirm = $('#pw_confirm_input').val();
            if (pw == pw_confirm)
                return true;
            else return false;
        }

        function CheckIDAllow() {
            $.ajax({
                url: "./Ajax/IDCheck.php",
                type: "post",
                data: {
                    "ID": $('#id_input').val()
                },
                dataType: "json",
                success: function(data) {
                    //ID 사용 가능할 시 
                    if (data.check) {
                        $('#id_deny').hide();
                        $('#id_allow').show();
                        $('#id_check').attr('data-check', '1');
                    } else { //ID 사용 불가
                        $('#id_deny').show();
                        $('#id_allow').hide();
                        $('#id_check').attr('data-check', '0');
                    }
                },
                error: function(err) {

                }
            });
        }
    </script>
</head>

<body>
    <div class="content">
        <div class="bg-transpert signup_div center-block">
            <h3 class="card-title">회원가입</h3>
            <div class="form-group">
                <form id="sign_up_form" method="POST" action="./Post/PostSignUp.php" enctype="multipart/form-data">
                    <input hidden id="id_check" data-check="0">
                    <input class="form-control" id="id_input" name="id" type="text" placeholder="ID">
                    <span id="id_deny" style="color:red">이미 사용중인 ID입니다</span>
                    <span id="id_allow" style="color:royalblue">사용 가능한 ID입니다</span>
                    <br>
                    <input class="form-control" id="pw_input" name="pw" type="password" placeholder="비밀번호(영문 대/소문자 및 특수문자 포함 8자 이상)">
                    <span id="pw_deny" style="color:red">비밀번호는 영문 대/소문자 및 특수문자 포함 8자 이상이여야 합니다</span>
                    <span id="pw_allow" style="color:royalblue">사용 가능한 비밀번호입니다</span>
                    <br>
                    <input hidden id="pw_check" data-check="0">
                    <input class="form-control" id="pw_confirm_input" name="pw_confirm" type="password" placeholder="비밀번호 확인">
                    <span id="pw_dif" style="color:red">비밀번호가 일치하지 않습니다</span>
                    <span id="pw_same" style="color:royalblue">비밀번호가 일치합니다</span>
                    <br>
                    <input class="form-control" id="name_input" name="name" type="text" placeholder="이름"><br>
                    <input class="form-control" id="business_name_input" name="business_name" type="text" placeholder="사업장명"><br>
                    <input class="form-control" id="business_num_input" name="business_num" type="text" placeholder="사업자 번호"><br>
                    <input class="form-control" id="business_addr_input" name="business_addr" type="text" placeholder="사업장 주소지"><br>
                    <label>대표사진 설정</label>
                    <input type="file" accept="image/*" class="form-control-file" id="file_input" name="img_file" /><br>
                    <div class="form-group">
                        <label>상품 분류</label><br>
                        <select class="form-confrol" name="cat" id="cat_select">
                            <option value="0">선택</option>
                            <?php
                            while ($data = mysqli_fetch_array($result)) {
                                echo "<option value='{$data['CatID']}'>";
                                echo $data['Name'];
                                echo "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </form>
                <button class="btn btn-block btn-success" id="sign_up_btn">회원가입</button>
            </div>
        </div>
    </div>
</body>

</html>