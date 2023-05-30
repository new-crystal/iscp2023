<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// conference program book 관리
	if ($flag === "save") {

		$sql =	"UPDATE info_event
				SET
					title = '".$_POST['title']."', 
					period_event_start			= '".$_POST['period_event_start']."',		period_event_end		= '".$_POST['period_event_end']."',
					period_event_pre_start		= '".$_POST['period_event_pre_start']."',	period_event_pre_end	= '".$_POST['period_event_pre_end']."',
					period_live_start			= '".$_POST['period_live_start']."',		period_live_end			= '".$_POST['period_live_end']."',
					period_poster_start			= '".$_POST['period_poster_start']."',		period_poster_end		= '".$_POST['period_poster_end']."',
					period_lecture_start		= '".$_POST['period_lecture_start']."',		period_lecture_end		= '".$_POST['period_lecture_end']."',
					period_sponsorship_start	= '".$_POST['period_sponsorship_start']."',	period_sponsorship_end	= '".$_POST['period_sponsorship_end']."',
					modify_admin_idx			= '".$_SESSION['ADMIN']['idx']."'
				";

		if (sql_query($sql)) {
			$price_arr = explode('^&', htmlspecialchars_decode($_POST['prices']));
			if (count($price_arr) > 0) {
				foreach($price_arr as $li){
					list($flag, $idx, $type, $off_member_usd, $off_guest_usd, $on_member_usd, $on_guest_usd, $off_member_krw, $off_guest_krw, $on_member_krw, $on_guest_krw) = explode('|', $li);

					if ($flag !== "") {
						if ($flag == "insert") { // insert
							$sql =	"INSERT INTO 
										info_event_price 
										(
											type_en, 
											off_member_usd, off_guest_usd, on_member_usd, on_guest_usd, 
											off_member_krw, off_guest_krw, on_member_krw, on_guest_krw, 
											register_admin_idx
										) 
									VALUES 
										(
											'".$type."', 
											'".$off_member_usd."', '".$off_guest_usd."', '".$on_member_usd."', '".$on_guest_usd."', 
											'".$off_member_krw."', '".$off_guest_krw."', '".$on_member_krw."', '".$on_guest_krw."', 
											'".$_SESSION['ADMIN']['idx']."'
										)";
						} else { // delete
							$sql =	"UPDATE info_event_price 
									SET
										is_deleted = 'Y', 
										delete_date = NOW()
									WHERE idx = '".$idx."'";
						}
						if (!sql_query($sql)) {
							return_value(500, "가격정보 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
						}
					}
				}
			}

			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "행사 정보 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 결과값 반환 공통화
	function return_value($code, $msg, $arr=array()){
		$arr["code"] = $code;
		$arr["msg"] = $msg;
		echo json_encode($arr);
		exit;
	}