<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>
<?php
//	print_r2($_SERVER); exit;

if ($_SESSION["USER"]) {
    echo "<script>alert('You are already logged in.'); location.replace(PATH+'mypage.php');</script>";
    exit;
}
?>
<section class="container form_page login">
    <!-- <div class="sub_background_box">
		<div class="sub_inner">
			<div>
				<h2>Login</h2>
				<ul>
					<li>Home</li>
					<li>Sign Up</li>
					<li>Login</li>
				</ul>
			</div>
		</div>
	</div> -->
    <div class="inner">
        <form class="form_box">
            <h3>LOGIN</h3>
            <!-- <p>If you have already signed up, Please Login with your ID(E-mail) and Password.</p> -->
            <div class="clearfix log_box">
                <ul class="log_input">
                    <li>
                        <input type="text" name="email" placeholder="<?= $locale("id") ?>"
                            value="<?= $_COOKIE["session_email"] ?>">
                    </li>
                    <li>
                        <input type="password" name="password" placeholder="<?= $locale("password") ?>">
                    </li>
                </ul>

            </div>
            <div class="id_save">
                <input type="checkbox" id="id_save" class="checkbox"
                    <?= $_COOKIE["session_email"] != null ? "checked" : "" ?>>
                <label for="id_save"><span>Keep me signed in</span></label>
            </div>
            <button type="button" class="btn login_btn"><?= $locale("login") ?></button>
            <ul class="login_info">
                <li>
                    <!-- - Forgotten your password? -->
                    <button type="button" class="btn"
                        onclick="window.location.href='./find_password.php';"><?= $locale("find_password") ?></button>
                    <!-- <button type="button" class="pre btn"><?= $locale("find_password") ?></button> -->
                </li>
                <li>
                    <div class="login_btn_bar"></div>
                </li>
                <li>
                    <!-- - Please sign up if this is your first visit. -->
                    <button type="button" class="btn sign_up_btn"
                        onclick="window.location.href='./signup.php';"><?= $locale("signup") ?></button>
                    <!-- <button type="button" class="btn sign_up_btn pre"><?= $locale("signup") ?></button> -->

                </li>
            </ul>
        </form>

    </div>


</section>
<script>
// const pre = document.querySelector(".pre")
// pre.addEventListener("click", () => alert("준비 중입니다."))
$(document).ready(function() {
    $('input').on('keyup', function(e) {
        if (e.keyCode == '13') {
            login();
        }
    });
    $(".login_btn").on("click", function() {
        login();
    });
});

// login
function login() {
    var email = $("input[name=email]").val();
    var password = $("input[name=password]").val();

    if (email == "") {
        alert(locale(language.value)("check_email"));
        return false;
    } else if (password == "") {
        alert(locale(language.value)("check_password"));
        return false;
    }

    $.ajax({
        url: "./ajax/client/ajax_member.php",
        type: "POST",
        data: {
            flag: "login",
            email: email,
            password: password
        },
        dataType: "JSON",
        success: function(res) {
            if (res.code == 200) {
                // 아이디 저장을 선택 했을 경우
                if ($("#id_save").is(":checked")) {
                    setCookie("session_email", email, 30);
                } else {
                    removeCookie("session_email");
                }

                var href_path = "/main";

                var from = "<?= $_GET['from'] ?>";
                if (from != "") {
                    href_path += "/" + from
                }

                var toDate = new Date();
                toDate.setHours(toDate.getHours() + ((23 - toDate.getHours()) + 9));
                toDate.setMinutes(toDate.getMinutes() + (60 - toDate.getMinutes()));
                toDate.setSeconds(0);
                document.cookie = "member_idx=" + res.idx + "; path=/; expires=" + toDate.toGMTString() +
                    ";";

                location.href = href_path;
            } else if (res.code == 400) {
                alert(locale(language.value)("not_matching_email"));
                return false;
            } else if (res.code == 401) {
                alert(locale(language.value)("not_matching_password"));
                return false;
            } else if (res.code == 402) {
                alert(locale(language.value)("not_certified_email"));
                return false;
            } else {
                alert(locale(language.value)("reject_msg"));
            }
        }
    });
}
</script>
<?php include_once('./include/footer.php'); ?>