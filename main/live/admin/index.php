<?php include_once('./include/head.php');?>
<html>
	<body>
	<section class="adm_login">
		<div class="logo"><img src="../img/footer_logo.png" alt="logo"><span>관리자</span></div>
		<input type="text" name="id" placeholder="아이디">
		<input type="password" name="password" placeholder="비밀번호">
		<button class="btn submit" onclick="login();">로그인</button>
	</section>
	</body>
<script>
    function login(){
        var id = $("input[name=id]").val();
        var password = $("input[name=password]").val();

        if(id == "") {
            alert("아이디를 입력해주세요.");
            return false;
        } else if(password == "") {
            alert("비밀번호를 입력해주세요.");
            return false;
        }

        $.ajax({
            url : "../ajax/admin/ajax_admin.php",
            type : "POST",
            data : {
                flag : "login",
                id : id,
                password : password
            },
            dataType : "JSON",
            success : function(res){
                if(res.code == 200) {
                    if (res.url == "") {
                        alert('접근 권한을 확인하세요.');
                    } else {
                        window.location.href = "./"+res.url;
                    }
                } else if(res.code == 401) {
                    alert(res.msg);
                    return false;
                } else {
                    alert("일시적으로 요청이 거절되었습니다. 잠시 후 다시 시도해주세요.");
                    return false;
                }
            }
        });

    }
    $('input[name=password]').on('keypress', function(e){
        if(e.keyCode == '13'){
            login();
        }
    });
</script>
</html>