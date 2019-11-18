<!DOCTYPE html>
<html>

<head>
    <title>비밀번호 재설정</title>
    <?php
    include "head.php";
    include_once "config.php";
    ?>

    <script>
        var code;
        var ID;
        $(function() {
            $('#after').hide();
            $('#setPassword').hide();
            $('#pw_allow').hide();
            $('#pw_deny').hide();
            $('#pw_dif').hide();
            $('#pw_same').hide();
            $('#confirm_btn').click(function() {
                checkInput();
            });
            $("#verify_btn").click(function() {
                CheckCode();
            });

            $('#pw_input').change(function() {
                if (CheckPassword()) {
                    $('#pw_allow').show();
                    $('#pw_deny').hide();
                } else {
                    $('#pw_allow').hide();
                    $('#pw_deny').show();
                }
            });

            $('#pw_confirm_input').change(function() {
                if (SamePassword()) {
                    $('#pw_same').show();
                    $('#pw_dif').hide();
                } else {
                    $('#pw_same').hide();
                    $('#pw_dif').show();
                }
            });


            $('#ch_btn').click(function() {
                if (CheckPassword && SamePassword) {
                    ChangePassword();
                } else {
                    alert('비밀번호를 확인하세요');
                }
            });

        });

        function checkInput() {
            if ($('#mail_input').val().length == 0) {
                alert('메일 주소를 입력해주세요');
            } else {
                SendMail();
            }
        }

        function SendMail() {
            $.ajax({
                url: "./Ajax/Mail.php",
                type: "post",
                data: {
                    "mail": $('#mail_input').val()
                },
                dataType: "json",
                success: function(data) {
                    //ID 사용 가능할 시 
                    if (data.complete) {
                        alert('인증번호가 발송되었습니다');
                        $('#before').fadeOut();
                        code = data.code;
                        ID = $('#mail_input').val();
                        $('#id').attr('data-ID', ID);
                        setTimeout(() => {
                            $('#after').fadeIn();
                        }, 400);
                    } else { //ID 사용 불가
                        alert('가입되지 않은 메일입니다');
                    }
                },
                error: function(err) {
                    alert('오류가 발생하였습니다');
                    console.log(err);
                }
            });
        }
        var verify = false;

        function CheckCode() {
            if (code == $('#code').val()) {
                verify = true;
                $('#after').fadeOut();
                setTimeout(() => {
                    $('#setPassword').fadeIn();
                }, 400);
            } else {
                alert('인증번호가 일치하지 않습니다');
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
                if (password.indexOf(lower.charAt(i)) != -1) {
                    lowerB = true;
                    break;
                }
            }
            for (var i = 0; i < upper.length; i++) {
                if (password.indexOf(upper.charAt(i)) != -1) {
                    upperB = true;
                    break;
                }
            }
            for (var i = 0; i < special.length; i++) {
                if (password.indexOf(special.charAt(i)) != -1) {
                    specialB = true;
                    break;
                }
            }

            if (lowerB && upperB && specialB && password.length > 8) {
                $('#pw_check').attr('data-check', '1');
                return true;
            } else {
                $('#pw_check').attr('data-check', '0');
                return false;
            }
        }

        function SamePassword() {
            var pw = $('#pw_input').val();
            var pw_confirm = $('#pw_confirm_input').val();
            if (pw == pw_confirm) {
                $('#pw_same').attr('data-check', '1');
                return true;
            } else {
                $('#pw_same').attr('data-check', '0');
                return false;
            }
        }

        function ChangePassword() {
            $.ajax({
                url: "./Ajax/ChangePw.php",
                type: "post",
                data: {
                    "ID":$('#id').attr('data-id'),
                    "Password":$('#pw_input').val()
                },
                dataType: "json",
                success: function(data) {
                    if (data.result) {
                        alert('비밀번호가 변경되었습니다');
                        location.href="Login.php";
                    } else { 
                        alert('오류 발생');
                    }
                },
                error: function(err) {
                    alert('오류가 발생하였습니다');
                    console.log(err);
                }
            });
        }
    </script>
</head>

<body>
    <div class="bg-transpert center-block login_div">
        <h3 class="card-title">비밀번호 재설정</h3>
        <div id="before">
            <p>가입할 때 사용한 이메일을 입력해주세요</p>
            <input class="form-control" type="email" id="mail_input" name="mail" placeholder="메일 주소">
            <br>
            <button id="confirm_btn" class="btn btn-block btn-success">확인</button>
        </div>

        <div id="after">
            <p>인증번호 확인</p>
            <input type="text" class="form-control" id="code" placeholder="인증번호">
            <br>
            <button id="verify_btn" class="btn btn-block btn-success">인증번호 확인</button>
        </div>

        <div id="setPassword">
            <p>새 비밀번호를 입력해주세요</p>
            <input type="text" hidden data-ID="" id="id" name="ID" value="">
            <input type="password" class="form-control" placeholder="새 비밀번호" name="pw" id="pw_input">
            <span id="pw_deny" style="color:red">비밀번호는 영문 대/소문자 및 특수문자 포함 8자 이상이여야 합니다</span>
            <span id="pw_allow" style="color:royalblue">사용 가능한 비밀번호입니다</span>
            <input hidden data-check="false" id="pw_check">
            <br>
            <input type="password" class="form-control" placeholder="비밀번호 확인" name="pw_confirm" id="pw_confirm_input">
            <span id="pw_dif" style="color:red">비밀번호가 일치하지 않습니다</span>
            <span id="pw_same" style="color:royalblue">비밀번호가 일치합니다</span>
            <input hidden data-check="false" id="pw_same">
            <br>
            <button id="ch_btn" class="btn btn-block btn-success">비밀번호 재설정</button>
        </div>
    </div>
</body>

</html>