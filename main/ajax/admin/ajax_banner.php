<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// 이벤트 당첨 상품 전달
	if ($flag === "save") {

		$sql_origin =	"SELECT * FROM banner WHERE idx = '".$_POST['idx']."'";
		$origin = sql_fetch($sql_origin);

		// 파일업로드 및 유효성 검사
		$pc_en = simple_file_upload($_FILES['pc_en'], $origin['pc_en_img']);
		$mo_en = simple_file_upload($_FILES['mo_en'], $origin['mo_en_img']);
		$pc_ko = simple_file_upload($_FILES['pc_ko'], $origin['pc_ko_img']);
		$mo_ko = simple_file_upload($_FILES['mo_ko'], $origin['mo_ko_img']);

		$sql =	"UPDATE banner
				SET
					pc_en_img = '".$pc_en."',
					mo_en_img = '".$mo_en."',
					pc_ko_img = '".$pc_ko."',
					mo_ko_img = '".$mo_ko."',
					modify_admin_idx = '".$_SESSION['ADMIN']['idx']."',
					modify_date = NOW()
				WHERE idx = '".$_POST['idx']."'";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 결과값 반환 공통화
	function return_value($code, $msg, $arr=array()){
		$arr["code"] = $code;
		$arr["msg"] = $msg;
		echo json_encode($arr);
		exit;
	}

	// 파일 업로드 간소화
	function simple_file_upload($file_obj, $origin_val){
		if($file_obj){
			$file_type = explode("/", $file_obj["type"])[0];

			if($file_type == "image") {
				$file_obj["name"] = htmlspecialchars($file_obj["name"], ENT_QUOTES);
				$file_no = upload_image($file_obj, 6);

				if ($file_no != "" && $file_no > 0) {
					return $file_no;
				} else {
					return_value(500, "파일업로드가 실패했습니다.");
				}
			} else {
				return_value(403, "이미지 파일만 등록가능합니다.");
			}
		} else {
			return $origin_val;
		}
	}
?>