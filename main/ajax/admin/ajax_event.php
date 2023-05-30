<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// 이벤트 당첨 상품 전달
	if ($flag === "delivery_luckydraw" || $flag === "delivery_sameimg") {
		$table_name = "event_".explode('_', $flag)[1];

		$sql =	"UPDATE ".$table_name."
				SET
					delivery_yn = '".$_POST['status']."'
				";
		$sql .=	"WHERE idx = '".$_POST['idx']."'";
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
?>