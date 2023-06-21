<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>
<!-- //++++++++++++++++++++++++++ -->
<?php

$sql_during = "SELECT
						IF(NOW() BETWEEN '2022-08-18 17:00:00' AND '2022-09-06 18:00:00', 'Y', 'N') AS yn
					FROM info_event";
$during_yn = sql_fetch($sql_during)['yn'];

//할인 가격 끝 여부
$sql_during =    "SELECT
						IF(NOW() >= '2022-07-28 09:00:00', 'Y', 'N') AS yn
					FROM info_event";
$r_during_yn = sql_fetch($sql_during)['yn'];

//특정 회원 가격 변동 이후 삭제
//if($registration_idx == 512) {
//	$r_during_yn = 'N';
//}

if ($_SESSION['USER']['idx'] == 336) {
    $during_yn = 'Y';
}

if ($during_yn !== "Y") {
?>

    <section class="container submit_application registration_closed">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>Invited Speakers</h2>
                    <!-- <ul class="clearfix">
					<li>Home</li>
					<li>Registration</li>
				</ul> -->
                </div>
            </div>
        </div>
        <div class="inner coming">
            <div class="sub_banner">
                <h5>coming soon...</h5>
            </div>
        </div>
    </section>


<?php
} else {
?>
    <!-- //++++++++++++++++++++++++++ -->
    <section class="container invited">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>Invited Speakers</h2>
                    <ul>
                        <li>Home</li>
                        <li>Program</li>
                        <li>Invited Speakers</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="inner">
            <div>
                <div class="searchArea">
                    <!-- <form action=""> -->
                    <div class="sort">
                        <div class="all on"><a href="#">ALL</a></div>
                        <ul class="sort first_words">
                            <li><a href="#" class="click_sumbit">A</a></li>
                            <li><a href="#" class="click_sumbit">B</a></li>
                            <li><a href="#" class="click_sumbit">C</a></li>
                            <li><a href="#" class="click_sumbit">D</a></li>
                            <li><a href="#" class="click_sumbit">E</a></li>
                            <li><a href="#" class="click_sumbit">F</a></li>
                            <li><a href="#" class="click_sumbit">G</a></li>
                            <li><a href="#" class="click_sumbit">H</a></li>
                            <li><a href="#" class="click_sumbit">I</a></li>
                            <li><a href="#" class="click_sumbit">J</a></li>
                            <li><a href="#" class="click_sumbit">K</a></li>
                            <li><a href="#" class="click_sumbit">L</a></li>
                            <li><a href="#" class="click_sumbit">M</a></li>
                            <li><a href="#" class="click_sumbit">N</a></li>
                            <li><a href="#" class="click_sumbit">O</a></li>
                            <li><a href="#" class="click_sumbit">P</a></li>
                            <li><a href="#" class="click_sumbit">Q</a></li>
                            <li><a href="#" class="click_sumbit">R</a></li>
                            <li><a href="#" class="click_sumbit">S</a></li>
                            <li><a href="#" class="click_sumbit">T</a></li>
                            <li><a href="#" class="click_sumbit">U</a></li>
                            <li><a href="#" class="click_sumbit">V</a></li>
                            <li><a href="#" class="click_sumbit">W</a></li>
                            <li><a href="#" class="click_sumbit">X</a></li>
                            <li><a href="#" class="click_sumbit">Y</a></li>
                            <li><a href="#" class="click_sumbit">Z</a></li>
                        </ul>
                        <ul class="category">
                            <li><a href="#" class="click_sumbit">Plenary Lectures</a></li>
                            <li><a href="#" class="click_sumbit">Symposia</a></li>
                            <li><a href="#" class="click_sumbit">Workshops</a></li>
                            <li><a href="#" class="click_sumbit">Joint Symposia</a></li>
                        </ul>
                    </div>
                    <div class="bg">
                        <input type="text" name="keyword" id="keyword" value="" onkeyup="enterkey()">
                        <input id="submit" type="button" value="Search">
                    </div>
                    <!-- </form>	 -->
                </div>
                <ul class="speaker_list">
                </ul>
            </div>
        </div>
    </section>
<?php
}
?>
<input type="hidden" name="first_word">
<input type="hidden" name="session_word">

<script>
    var brian_height = '';

    $(document).ready(function() {
        search_list();
    });

    function enterkey() {
        if (window.event.keyCode == 13) {
            // 엔터키가 눌렸을 때
            ajax_submit(3);
        }
    }


    $(".all").click(function() {

        $(".all").addClass("on");
        $(".first_words").find(".on").removeClass("on");
        $(".category").find(".on").removeClass("on");
        $("#keyword").val("");
        $("input[name=first_word]").val("");
        $("input[name=session_word]").val("");
        search_list();
    });

    $(".first_words li").click(function() {

        $(".all").removeClass("on");
        $(".first_words").find(".on").removeClass("on");
        $(this).addClass("on");

        var first_word_value = $(this).children().html();
        $("input[name=first_word]").val(first_word_value);

        ajax_submit(1);

    });


    $(".category li").click(function() {
        $(".all").removeClass("on");
        $(".category").find(".on").removeClass("on");
        $(this).addClass("on");

        var session_word_value = $(this).children().html();
        if (session_word_value === "Plenary lectures") {
            session_word_value = "Plenary";
        } else if (session_word_value === "Symposia") {
            session_word_value = "Symposium";
        } else if (session_word_value === "Workshops") {
            session_word_value = "Workshop";
        } else if (session_word_value === "Joint Symposia") {
            session_word_value = "joint";
        }

        $("input[name=session_word]").val(session_word_value);

        ajax_submit(2);

    });

    $("#submit").click(function() {
        ajax_submit(3);
    });

    function ajax_submit(order) {
        var first_word = $("input[name=first_word]").val();
        var session_word = $("input[name=session_word]").val();
        var search_word = $("#keyword").val();

        search_list(first_word, session_word, search_word, order);

    }


    function search_list(first_word = null, session_word = null, search_word = null, order = null) {

        var category_bool = $(".category").children().hasClass("on");

        var data = {
            "flag": "invited_speaker",
            "first_word": first_word,
            "session_word": session_word,
            "search_word": search_word,
            "order": order,
            "category_bool": category_bool
        };

        $.ajax({
            url: PATH + "ajax/client/ajax_invited_speaker.php",
            type: "POST",
            data: data,
            dataType: "JSON",
            success: function(res) {
                if (res.code == 200) {

                    //console.log(res);

                    var html = "";

                    $(".speaker_list").html(html);

                    var s_list = res["list"];

                    for (var i = 0; i < res["total_count"]; i++) {

                        var list = s_list[i];
                        var logo_img = "";
                        if (list["image"] == "./img/footer_logo.png") {
                            logo_img = " logo_img";
                        }

                        html += "<li data-idx='" + list['idx'] + "'>";
                        html += "<div class='clearfix2'>";
                        html += "<div class='speaker_img" + logo_img + "' style='background:url(" + "\"" + list[
                            "image"] + "\"" + ") no-repeat center /cover;'></div>";
                        html += "<div class='speaker_info'>";
                        html += "<p class='bold'>" + list['first_name'] + " " + list['last_name'] + "</p>";
                        html += "<p>" + list['affiliation'] + "</p>";
                        html += "<p class='italic'>" + list['nation'] + "</p>";
                        html += "</div>";
                        html += "</div>";
                        html += "<div class='lecture_title'>";
                        html += "<strong>" + list['session_type'] + "</strong>";
                        html += list['title'];
                        if (list['session_type2']) {
                            html += "<strong>" + list['session_type2'] + "</strong>";
                            html += list['title2'];
                        }
                        html += "</div>";
                        html += "</li>";

                        $(".speaker_list").html(html);

                    }
                    var speaker_arr = [];
                    var max = '';
                    var text_height = '';
                    //$(window).resize(function(){
                    //	var first_height = $(".speaker_list li:first-child .lecture_title").height();
                    //	first_height = Math.ceil(first_height);
                    //	$(".speaker_list li").find(".lecture_title").height(first_height);
                    //	$(".speaker_list li:first-child .lecture_title, .speaker_list li.brian .lecture_title, .speaker_list li.edward .lecture_title").css("height","auto");
                    //	brian_height = $(".speaker_list li.brian .lecture_title").height();
                    //	brian_height = Math.ceil(brian_height);
                    //	edward_height = $(".speaker_list li.edward .lecture_title").height();
                    //	edward_height = Math.ceil(edward_height);

                    //	list_layout();
                    //	
                    //});
                    //$(window).trigger("resize")

                } else if (res.code == 400) {
                    alert(res.msg);
                    return;
                }
            }
        });
    }

    //function list_layout(){
    //	var li_1 = $(".speaker_list li:first-child").offset().left;
    //	var li_2 = $(".speaker_list li:nth-child(2)").offset().left;
    //	var li_3 = $(".speaker_list li:nth-child(3)").offset().left;
    //	var brian_left = $(".speaker_list li.brian").offset().left;
    //	var edward_left = $(".speaker_list li.edward").offset().left;

    //	if ($(window).width() >= 1024){
    //		if (brian_left == li_1){
    //			$(".speaker_list li.brian").next("li").find(".lecture_title").height(brian_height);
    //			$(".speaker_list li.brian").next("li").next("li").find(".lecture_title").height(brian_height);
    //		}
    //		if (brian_left == li_2){
    //			$(".speaker_list li.brian").prev("li").find(".lecture_title").height(brian_height);
    //			$(".speaker_list li.brian").next("li").find(".lecture_title").height(brian_height);
    //		}
    //		if (brian_left == li_3){
    //			$(".speaker_list li.brian").prev("li").find(".lecture_title").height(brian_height);
    //			$(".speaker_list li.brian").prev("li").prev("li").find(".lecture_title").height(brian_height);
    //		}
    //	} else if ($(window).width() >= 769){
    //		if (brian_left == li_1){
    //			$(".speaker_list li.brian").next("li").find(".lecture_title").height(brian_height);
    //			$(".speaker_list li.brian").prev("li").find(".lecture_title").height(first_height);
    //		}
    //		if (brian_left == li_2){
    //			$(".speaker_list li.brian").prev("li").find(".lecture_title").height(brian_height);
    //			$(".speaker_list li.brian").next("li").find(".lecture_title").height(first_height);
    //		}
    //	}

    //	if ($(window).width() >= 1024){
    //		if (edward_left == li_1){
    //			$(".speaker_list li.edward").next("li").find(".lecture_title").height(edward_height);
    //			$(".speaker_list li.edward").next("li").next("li").find(".lecture_title").height(edward_height);
    //		}
    //		if (edward_left == li_2){
    //			$(".speaker_list li.edward").prev("li").find(".lecture_title").height(edward_height);
    //			$(".speaker_list li.edward").next("li").find(".lecture_title").height(edward_height);
    //		}
    //		if (edward_left == li_3){
    //			$(".speaker_list li.edward").prev("li").find(".lecture_title").height(edward_height);
    //			$(".speaker_list li.edward").prev("li").prev("li").find(".lecture_title").height(edward_height);
    //		}
    //	} else if ($(window).width() >= 769){
    //		if (edward_left == li_1){
    //			$(".speaker_list li.edward").next("li").find(".lecture_title").height(edward_height);
    //			$(".speaker_list li.edward").prev("li").find(".lecture_title").height(first_height);
    //		}
    //		if (edward_left == li_2){
    //			$(".speaker_list li.edward").prev("li").css("background-color","red");
    //			$(".speaker_list li.edward").prev("li").find(".lecture_title").height(edward_height);
    //			$(".speaker_list li.edward").next("li").find(".lecture_title").height(first_height);
    //		}
    //	}

    //}
</script>

<?php include_once('./include/footer.php'); ?>