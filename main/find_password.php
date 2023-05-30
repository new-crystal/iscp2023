<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>

<section class="container">
    <!-- <div class="sub_background_box">
		</div> -->
    <div class="sub_inner">

        <!-- <ul>
			<li>Home</li>
			<li>Login</li>
					<li>Find Password</li>
				</ul> -->

    </div>
    <div class="inner find_password">
        <div class="box_line">
            <div>
                <h1 class="find_title">Find Password</h1>
                <h3 class="sub_section_title">
                    <!-- <?= $locale("find_password") ?> -->
                    Forgotten your password?
                </h3>
                <p>
                    <!-- <?= $locale("enter_email_txt") ?> -->
                    If you do not remember your password, please enter your ID(Email).
                    <br />Temporary password will be sent out to your e-mail.
                    <br />After you login with the temporary password,
                    <br />you may change to a new password at personal information.
                </p>
            </div>
            <form class="find_password_form" name="find_password_form" onsubmit="return false;">
                <ul>
                    <li>
                        <input class="find_pw_input" name="email" placeholder="<?= $locale("id") ?>">
                    </li>
                </ul>
                <!-- <div class="text_r"> -->
                <!-- 	<a href="./login.php"><?= $locale("login") ?> ></a> -->
                <!-- </div> -->
                <div class="btn_wrap centerT">
                    <button type="button" class="btn blue_btn submit_btn">
                        <?= $locale("get_temporary_password_btn") ?>
                        Find Password
                    </button>
                </div>
            </form>
            <p class="cf_txt">
                <span class="red_txt">If you don’t remember your e-mail address, please contact the Secretariat.</span>
                <!-- <br />E-mail : secretariat@icola.org -->
            </p>
        </div>
    </div>
</section>
<div class="loading"><img src="./img/icons/loading.gif" /></div>

<script>
    var alreadyProcess = false; // 더블 클릭 방지

    $(document).ready(function() {

        // 비밀번호 찾기 Enter
        $("input[name=email]").on("keyup", function(key) {
            if (key.keyCode == 13) {
                $(".submit_btn").trigger("click");
            }
        });

        // 비밀번호 찾기 버튼
        $(".submit_btn").on("click", function() {
            var email = $("input[name=email]").val();

            if (email == "" || email == "undefined" || email == null) {
                alert(locale(language.value)("check_email"));
                return false;
            }

            if (alreadyProcess) {
                return false;
            }

            alreadyProcess = true;

            $(".loading").show();
            $("body").css("overflow-y", "hidden");

            $.ajax({
                url: PATH + "ajax/client/ajax_gmail.php",
                type: "POST",
                data: {
                    flag: "find_password",
                    email: email
                },
                dataType: "JSON",
                success: function(res) {
                    if (res.code == 200) {
                        alert(locale(language.value)("send_mail_success"));
                    } else if (res.code == 401) {
                        alert(locale(language.value)("not_exist_email"));
                        return false;
                    } else if (res.code == 400) {
                        alert(locale(language.value)("error_find_password"));
                        return false;
                    } else {
                        alert(locale(language.value)("reject_msg"));
                        return false;
                    }
                },
                complete: function() {
                    $(".loading").hide();
                    $("body").css("overflow-y", "auto");

                    alreadyProcess = false;
                },
                error : function(request, status, error ) {
                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
            });
        });
    });
</script>

<?php include_once('./include/footer.php'); ?>