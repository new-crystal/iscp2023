<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>
<?php include_once('./live/include/set_event_period.php'); ?>
<?php
$user_idx = $member["idx"] ?? -1;

// [22.04.25] 미로그인시 처리
if ($user_idx <= 0) {
    echo "<script>alert('Need to login'); location.replace(PATH+'login.php');</script>";
    exit;
}

/*쿼리수정 (제출 파일명까지 불러오도록) file table이랑 join
    $my_submission_list_query =   "
                                    SELECT
                                        idx, submission_code, DATE(register_date) AS regist_date, `type`,
                                        (CASE
                                            WHEN `type` = 0
                                            THEN abstract_title
                                            WHEN `type` = 1
                                            THEN cv
                                            ELSE ''
                                        END) AS title, 
                                        (CASE
                                            WHEN `type` = 0
                                            THEN 'Abstract'
                                            WHEN `type` = 1
                                            THEN 'Lecture'
                                            ELSE ''
                                        END) AS `type_name`,
                                        (CASE
                                            WHEN is_presentation = '0'
                                            THEN 'Completed'
                                            WHEN is_presentation = '1'
                                            THEN 'Completed'
                                            ELSE '-'
                                        END) AS status
                                    FROM request_abstract
                                    WHERE is_deleted = 'N'
                                    AND register = {$user_idx}
                                    AND parent_author IS NULL
                                    ORDER BY register_date DESC
                                ";
    */
/*$my_submission_list_query = " 
                                SELECT
									ra.idx, ra.submission_code, DATE(ra.register_date) AS regist_date, `type`,
									(CASE
										WHEN `type` = 0
										THEN abstract_title
										WHEN `type` = 1
										THEN cv.original_name
										ELSE ''
									END) AS title, 
									(CASE
										WHEN `type` = 0
										THEN 'Abstract'
										WHEN `type` = 1
										THEN 'Lecture'
										ELSE ''
									END) AS `type_name`,
									(CASE
										WHEN ra.is_presentation = '0'
										THEN 'Completed'
										WHEN ra.is_presentation = '1'
										THEN 'Completed'
										ELSE '-'
									END) AS status,
									lecture.original_name AS lecture_file_name, CONCAT(lecture.path,'/',lecture.save_name) AS lecture_path,
									cv.original_name AS cv_file_name, CONCAT(cv.path,'/',cv.save_name) AS cv_path
								FROM request_abstract as ra
								LEFT JOIN file lecture
									ON ra.notice_file = lecture.idx
								LEFT JOIN file cv
									ON ra.cv_file = cv.idx
									WHERE ra.is_deleted = 'N'
									AND ra.register = {$user_idx}
									AND ra.parent_author IS NULL
									ORDER BY ra.register_date DESC
									
    
    ";*/

$my_submission_list_query = "
		SELECT
			rs.idx, rs.`status`, 
			IFNULL(rs.title, '-') AS title,
			(
				CASE rs.`status`
					WHEN 0 THEN 'In progress'
					WHEN 1 THEN 'Complete'
				END
			) AS status_text,
			DATE(rs.register_date) AS register_ymd
		FROM request_submission AS rs
		WHERE rs.is_deleted = 'N'
		AND rs.register = '{$user_idx}'
		ORDER BY rs.idx DESC
	";


$submission_list = get_data($my_submission_list_query);

$total_count = count($submission_list);
$write_page = 10;
$write_row = 20;
$cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
$total_page = ceil($total_count / $write_row);
$url = $_SERVER['REQUEST_URI'];

$paging_admin = get_paging_arrow($write_row, $write_page, $cur_page, $total_count, $total_page, $url, $add);

$paging_html = $paging_admin['html'];

$start_row = $paging_admin['start_row'];
$end_row = $paging_admin['end_row'];
?>

<section class="container mypage sub_page">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2><?= $locale("mypage") ?></h2>
                <div class="color-bar"></div>
            </div>
        </div>
    </div>
    <div class="inner bottom_short">
        <!-- <div class="sub_banner"> -->
        <!-- 	<h1>Mypage</h1> -->
        <!-- </div> -->
        <div class="x_scroll tab_scroll">
            <ul class="tab_pager location">
                <li><a href="./mypage.php"><?= $locale("mypage_account") ?></a></li>
                <li><a href="./mypage_registration.php"><?= $locale("mypage_registration") ?></a></li>
                <li class="on"><a href="./mypage_abstract.php"><?= $locale("mypage_abstract") ?></a></li>
                <!-- <li><a href="./mypage_favorite.php"><?= $locale("mypage_favorite") ?></a></li> -->
            </ul>
        </div>
        <div>
            <div class="x_scroll">
                <table class="table table_responsive">
                    <thead>
                        <tr>
                            <!--<th>Type</th>
							논문번호 미노출
							<th>No</th>
							<th>File 1</th>
							<th>Status</th>
							<th>Sign date</th>
							<th>Modify</th>-->
                            <th>Title</th>
                            <th>Status</th>
                            <th>Sign date</th>
                            <th>Modify</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!$submission_list) {
                            echo "<tr><td colspan='6' class='centerT'>No Data</td></tr>";
                        } else {
                            for ($i = $start_row; $i <= $end_row; $i++) {
                                $sb = $submission_list[$i];
                                //$update_url = $list["type"] == 0 ? "./abstract_submission.php?idx=" : "lecture_submission.php?idx=";
                                //$update_url = $submission_list[$i]["type"] == 0 ? "./abstract_submission.php?idx=" : "lecture_submission.php?idx=";
                        ?>
                        <!--<tr class="centerT">
                            <td><?= $submission_list[$i]["type_name"] ?></td>
							논문번호 미노출
							<td><?= $list["submission_code"] ?></td>
							
							<td class="text_l"><?= $submission_list[$i]["title"] ?></td>
							<td><?= $submission_list[$i]["status"] ?></td>
							<td><?= $submission_list[$i]["regist_date"] ?></td>
							<td>
								<button type="button" class="btn modify_btn" onclick="javascript:location.href='<?= $update_url . $submission_list[$i]["idx"] ?>'"><?= $locale("modify_btn") ?></button>
								<button type="button" class="btn delete_btn" data-idx="<?= $submission_list[$i]["idx"] ?>"><?= $locale("delete_btn") ?></button>
							</td>
						</tr>-->
                        <tr>
                            <td class="text_l white_normal">
                                <?= strip_tags(htmlspecialchars_decode($sb["title"], ENT_QUOTES)) ?></td>
                            <td><?= $sb["status_text"] ?></td>
                            <td><?= $sb["register_ymd"] ?></td>
                            <td>
                                <!--<button type="button" class="btn modify_btn" onclick="javascript:location.href='<?= $update_url . $submission_list[$i]["idx"] ?>'"><?= $locale("modify_btn") ?></button>
								<button type="button" class="btn delete_btn" data-idx="<?= $submission_list[$i]["idx"] ?>"><?= $locale("delete_btn") ?></button>-->
                                <?php
                                        if ($sb['status'] == 0) {
                                        ?>
                                <button type="button" class="btn modify_btn"
                                    onclick="javascript:location.href='./abstract_submission.php?idx=<?= $sb["idx"] ?>'">Modify</button>
                                <?php
                                        } else {
                                        ?>
                                <button type="button" class="btn modify_btn"
                                    onclick="javascript:location.href='./abstract_submission3.php?idx=<?= $sb["idx"] ?>'">Detail</button>
                                <?php
                                        }
                                        ?>
                                <button type="button" class="btn delete_btn"
                                    data-idx="<?= $sb['idx'] ?>">Delete</button>
                            </td>
                        </tr>
                        <!-- <tr class="centerT"> -->
                        <!--     <td><?= $list["type_name"] ?></td> -->
                        <!-- 	<!--논문번호 미노출 -->
                        <!-- 	<td><?= $list["submission_code"] ?></td> -->
                        <!-- 	-->
                        <!-- 	<td class="text_l"><?= $list["title"] ?></td> -->
                        <!-- 	<td><?= $list["status"] ?></td> -->
                        <!-- 	<td><?= $list["regist_date"] ?></td> -->
                        <!-- 	<td> -->
                        <!-- 		<button type="button" class="btn modify_btn" onclick="javascript:location.href='<?= $update_url . $list["idx"] ?>'"><?= $locale("modify_btn") ?></button> -->
                        <!-- 		<button type="button" class="btn delete_btn" data-idx="<?= $list["idx"] ?>"><?= $locale("delete_btn") ?></button> -->
                        <!-- 	</td> -->
                        <!-- </tr> -->
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- <ul class="pagenation"> -->
        <!-- 	<li class="arrow"><a href=""> < </a></li> -->
        <!-- 	<li class="on"><a href="">1</a></li> -->
        <!-- 	<li><a href="">2</a></li> -->
        <!-- 	<li><a href="">3</a></li> -->
        <!-- 	<li><a href="">4</a></li> -->
        <!-- 	<li><a href="">5</a></li> -->
        <!-- 	<li class="arrow"><a href=""> > </a></li> -->
        <!-- </ul> -->
        <?= $paging_html; ?>
    </div>
</section>

<script>
const _PERIOD = JSON.parse('<?= json_encode($_PERIOD) ?>');
$(".table_open").click(function() {
    var member_idx = "<?= $_SESSION['USER']['idx'] ?>";
    var admin_idx = "<?= $_SESSION['ADMIN']['idx'] ?>";

    if (!member_idx && admin_idx) {
        alert('사용자 로그인 후 이용해주세요.');
    } else {
        $.ajax({
            url: "/main/ajax/client/ajax_lecture.php?flag=calc_score",
            type: "GET",
            dataType: "JSON",
            success: function(res) {
                var ymd, inner, day;
                _PERIOD.forEach(function(ymd, index) {
                    // daily
                    day = res.entrance_log[ymd];
                    inner = '';
                    if (day.watch_mins <= 0) {
                        inner += '<tr class="centerT"><td colspan="4">No Data</td></tr>';
                    } else {
                        inner += '<tr>';
                        inner += '<td>' + day.entrance_date + '</td>';
                        inner += '<td>' + day.exit_date + '</td>';
                        inner += '<td>' + day.watch_time + ' h</td>';
                        inner += '</tr>';
                    }
                    $('[name=lecs]').eq(index).html(inner);
                    $('[name=total_watch_time]').eq(index).html(day.watch_time + " h");

                    // score
                    inner = '';
                    if (res.score.length <= 0) {
                        inner += '<tr class="centerT"><td colspan="4">No Data</td></tr>';
                    } else {
                        res.score.forEach(function(group) {
                            inner += '<tr>';
                            inner += '<th>' + group.name + '</th>';
                            inner += '<td>' + group[ymd] + ' 점</td>';
                            inner += '<td>' + group.total + ' 점</td>';
                            inner += '</tr>';
                        });
                    }
                    $('[name=score]').eq(index).html(inner);
                });

                $(".table_pop").addClass("on");
            },
            error: function() {
                alert("일시적으로 요청이 거절되었습니다.");
            }
        });
    }
});

//탭
$(".table_pop .tab_pager li").click(function() {
    var _this = $(this);

    var _targets = $(".table_pop .tab_pager li");
    var i = 0;
    _targets.each(function(index) {
        if ($(this).children('a').text() == _this.children('a').text()) {
            i = index;
            return false;
        }
    });
    _targets.removeClass("on");
    _this.addClass("on");

    var _conts = _this.parents('ul').siblings('.tab_wrap').children('.tab_cont');
    _conts.removeClass("on");
    _conts.eq(i).addClass("on");
});
</script>
<script>
$(document).ready(function() {
    $(".delete_btn").on("click", function() {
        var idx = $(this).data("idx");
        if (confirm(locale(language.value)("submission_cancel_msg"))) {
            /*$.ajax({
                url : PATH+"ajax/client/ajax_submission.php",
                type : "POST",
                data : {
                    flag : "submission_delete",
                    idx : idx
                },
                dataType : "JSON",
                success : function(res){
                    if(res.code == 200) {
                        alert(locale(language.value)("complet_submission_cancel"));
                        location.reload();
                    } else if(res.code == 400) {
                        alert(locale(language.value)("error_submission_cancel"));
                        return false;
                    } else {
                        alert(locale(language.value("reject_msg")));
                        return false;
                    }
                }
            });*/
            $.ajax({
                url: PATH + "ajax/client/ajax_submission2022.php",
                type: "POST",
                data: {
                    flag: "delete",
                    idx: idx
                },
                dataType: "JSON",
                success: function(res) {
                    if (res.code == 200) {
                        alert(locale(language.value)("complet_submission_cancel"));
                        location.reload();
                    } else if (res.code == 400) {
                        alert(locale(language.value)("error_submission_cancel"));
                        return false;
                    } else {
                        alert(locale(language.value("reject_msg")));
                        return false;
                    }
                }
            });
        }
    });

    $(".modfy_btn").on("click", function() {
        <?php
            $_SESSION["abstract"] = "";
            ?>
    })
});
</script>

<?php include_once('./include/footer.php'); ?>