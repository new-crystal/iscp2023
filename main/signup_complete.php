<?php
include_once('./include/head.php');
include_once('./include/header.php');


//if(empty($_SESSION["signup_join"])){
//	echo "<script>alert('Inaccessible'); history.back();</script>";
//	exit;
//}

$nation_no =  $_SESSION["signup_join"]["nation_no"];

$nation_query = "SELECT
						*
					FROM nation
					WHERE idx=" . $nation_no;

$nation_list = sql_fetch($nation_query);

$nation_name = $nation_list["nation_en"];



$ksola_member_status = $_SESSION["signup_join"]["ksola_member_status"];

$email =  $_SESSION["signup_join"]["email"];
$first_name =  $_SESSION["signup_join"]["first_name"];
$last_name =  $_SESSION["signup_join"]["last_name"];
$affiliation =  $_SESSION["signup_join"]["affiliation"];
$department =  $_SESSION["signup_join"]["department"];
$category =  $_SESSION["signup_join"]["category"];
$category_input =  $_SESSION["signup_join"]["category_input"];
$nation_tel =  $_SESSION["signup_join"]["nation_tel"];
$phone =  $_SESSION["signup_join"]["phone"];
$date_of_birth =  $_SESSION["signup_join"]["date_of_birth"];
$food =  $_SESSION["signup_join"]["food"];
$name_kor =  $_SESSION["signup_join"]["name_kor"];
$affiliation_kor =  $_SESSION["signup_join"]["affiliation_kor"];
$licence_number =  $_SESSION["signup_join"]["licence_number"];
$specialty_number =  $_SESSION["signup_join"]["specialty_number"];
$nutritionist_number =  $_SESSION["signup_join"]["nutritionist_number"];
$licence_number2 =  $_SESSION["signup_join"]["licence_number2"];
$specialty_number2 =  $_SESSION["signup_join"]["specialty_number2"];
$nutritionist_number2 =  $_SESSION["signup_join"]["nutritionist_number2"];
$short_input =  $_SESSION["signup_join"]["short_input"];
$tel_nation_tel =  $_SESSION["signup_join"]["tel_nation_tel"];
$telephone1 =  $_SESSION["signup_join"]["telephone1"];
$telephone2 =  $_SESSION["signup_join"]["telephone2"];

$title = $_SESSION["signup_join"]["title"];
$title_input = $_SESSION["signup_join"]["title_input"];
$degree = $_SESSION["signup_join"]["degree"];
$degree_input = $_SESSION["signup_join"]["degree_input"];


$phone = phoneNumberTransform($nation_tel, $phone);
$telephone = "";
if (!empty($telephone1)) {
    $telephone = telphoneNumberTransform($tel_nation_tel, $telephone1, $telephone2);
}


//전화번호 변환
function telphoneNumberTransform($nation_tel, $phone, $phone2)
{
    if ($nation_tel != "" && $phone != "" && $phone2 != "") {
        if (strpos($phone, "0") == 0) {            //연락처에 맨 앞자리가 0으로 시작할 경우 국가전화번호와 합치기 위해 앞부분 0 삭제 ex)010-1234-1234 => 10-1234-1234
            $phone = substr($phone, 1);
        }
        $phone = $nation_tel . "-" . $phone . "-" . $phone2;
    }
    return $phone;
}

if (empty($licence_number)) {
    $licence_number = $licence_number2;
}
if (empty($specialty_number)) {
    $specialty_number = $specialty_number2;
}
if (empty($nutritionist_number)) {
    $nutritionist_number = $nutritionist_number2;
}



?>
<section class="container form_page sign_up">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Sign Up</h2>
                <ul>
                    <li>Home</li>
                    <li>Sign Up</li>
                    <li>Sign Up</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="inner">
        <div class="circle_title">
            Personal Information
        </div>
        <form class="table_wrap">
            <div>
                <table class="table detail_table">
                    <colgroup>
                        <col class="col_th" />
                        <col width="*" />
                    </colgroup>
                    <tbody>
                        <tr>
                            <th><?= $locale("country") ?></th>
                            <td><?= $nation_name ?></td>
                        </tr>
                        <?php
                        if ($nation_no == 25) {
                        ?>
                        <tr class="korea_radio">
                            <th>회원 여부</th>
                            <td>
                                <?= ($ksola_member_status !== "NON") ? "회원" : "비회원"; ?>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <th><?= $locale("id") ?></th>
                            <td><?= $email; ?></td>
                        </tr>
                        <!-- Name -->
                        <tr>
                            <th rowspan="2"><?= $locale("name") ?></th>
                            <td><?= $first_name . " " . $last_name; ?></td>
                        </tr>
                        <tr>
                            <td class="font_small brown_txt">Note.<br />your name will appear on your name badge exactly
                                as it is entered in these fields.<br />It you wish your name to appear in a specific
                                way, please contact the Secretariat via<br />e-mail(iscp@into-on.com)</td>
                        </tr>
                        <?php
                        if ($nation_no == 25) {
                        ?>
                        <tr class="korea_only">
                            <th><?= $locale("name") ?>(KOR)</th>
                            <td><?= $name_kor; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <th><?= $locale("affiliation") ?></th>
                            <td><?= $affiliation; ?></td>
                        </tr>
                        <?php
                        if ($nation_no == 25) {
                        ?>
                        <tr class="korea_only">
                            <th><?= $locale("affiliation") ?>(KOR)</th>
                            <td><?= $affiliation_kor; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <!-- Department -->
                        <tr>
                            <th><?= $locale("department") ?></th>
                            <td><?= $department; ?></td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td><?= $category != "Others" ? $category : $category_input; ?></td>
                        </tr>
                        <!--2022-05-09 추가사항-->
                        <tr>
                            <th>Title</th>
                            <td><?= $title != "Others" ? $title : $title_input; ?></td>
                        </tr>
                        <tr>
                            <th>Degree</th>
                            <td><?= $degree != "Others" ? $degree : $degree_input; ?></td>
                        </tr>
                        <?php
                        if ($nation_no == 25) {
                        ?>
                        <tr class="korea_only">
                            <th>의사 면허번호</th>
                            <td><?= $licence_number; ?></td>
                        </tr>
                        <tr class="korea_only">
                            <th>전문의 번호</th>
                            <td><?= $specialty_number; ?></td>
                        </tr>
                        <tr class="korea_only">
                            <th>영양사 면허번호</th>
                            <td><?= $nutritionist_number; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <th>Mobile Phone Number</th>
                            <td><?= $phone; ?></td>
                        </tr>
                        <!--2022-05-09 추가사항-->
                        <tr>
                            <th>Telephone</th>
                            <td><?= !empty($telephone) ? $telephone : "-"; ?></td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td><?= $date_of_birth; ?></td>
                        </tr>
                        <tr>
                            <th>Special Request for Food</th>
                            <td><?= $food != "Others" ? $food : $short_input; ?></td>
                        </tr>
                        <!-- <tr> -->
                        <!-- 	<th scope="row"><span class="label require">회원정보 공개여부</span></th> -->
                        <!-- 	<td> -->
                        <!-- 		<input name="infoYn" id="infoYn1" value="Y" type="radio"  /> -->
                        <!-- 		<label for="infoYn1">동의합니다.</label> -->
                        <!-- 		<input name="infoYn" id="infoYn2" value="N" type="radio"  /> -->
                        <!-- 		<label for="infoYn2">동의하지 않습니다.</label> -->

                        <!-- 		<span class="cmt block">(회원공간을 통해 회원께만 회원님의 소속, 전화번호, 이메일 정보를 보여줍니다.)</span> -->
                        <!-- 	</td> -->
                        <!-- </tr> -->

                        <!-- <tr> -->
                        <!-- 	<th scope="row"><span class="label require">메일수신 동의여부</span></th> -->
                        <!-- 	<td><input name="emailYn" id="emailYn1" value="Y" type="radio"  /> -->
                        <!-- 		<label for="emailYn1">동의합니다.</label> -->
                        <!-- 		<input name="emailYn" id="emailYn2" value="N" type="radio"  /> -->
                        <!-- 		<label for="emailYn2">동의하지 않습니다.</label> -->

                        <!-- 		<span class="cmt block">(동의하시면 학회에서 보내는 메일을 수신할 수 있습니다.)</span> -->
                        <!-- 	</td> -->
                        <!-- </tr> -->
                    </tbody>
                </table>
            </div>

            <input type="hidden" name="ksola_member_check">
        </form>
        <div class="pc_only">
            <div class="pager_btn_wrap half">
                <button type="button" class="btn dark_gray_btn" onclick="index_page();">Home</button>
            </div>
        </div>
        <div class="mb_only">
            <div class="pager_btn_wrap half">
                <button type="button" class="btn dark_gray_btn" onclick="index_page();">Home</button>
            </div>
        </div>
    </div>

</section>
<script>
function index_page() {

    window.location.replace("index.php");
}
</script>
<?php include_once('./include/footer.php'); ?>