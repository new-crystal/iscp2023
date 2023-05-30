<?php include_once("../../common/common.php");?>
<?php
	if($_POST["flag"] == "save") {

		$user_idx = $_SESSION["ADMIN"]["idx"];

		// 로그인 유무 체크
		if($user_idx == ""){
			return_value(401, "로그인이 필요합니다.");
		}

		$category_id = isset($_POST["c_id"]) ? preg_replace("/[^0-9]/","",$_POST["c_id"]) : "";
		$board_type = isset($_POST["b_type"]) ? @(int) preg_replace("/[^0-9]/","",$_POST["b_type"]) : "";
		$board_id = isset($_POST["b_id"]) ? preg_replace("/[^0-9]/","",$_POST["b_id"]) : "";

		// Basic 파라미터 유효성 검사
		if(($board_type != 0 && $board_type == "") || ($board_type != 0 && $board_type != 1 && $board_type != 2)){
			return_value(400, "게시글 유형이 유효하지 않습니다.");
		}

		if($board_type == 2 && $category_id == ""){
			return_value(400, "카테고리 정보가 유효하지 않습니다.");
		}


		if($board_id != ""){
			
			$sql = "SELECT idx FROM board WHERE idx = {$board_id} AND `type` = {$board_type} AND is_deleted = 'N'";
			$find_id = sql_fetch($sql)["idx"];
		
			if($find_id == ""){
				return_value(400, "게시글이 유효하지 않습니다.");
			}
		}

		$set = "";

		if($board_type != 2){
			// 파일업로드 및 유효성 검사
			if($_FILES["file"]){
				$file_type = explode("/", $_FILES["file"]["type"])[0];

				if($file_type == "image") {
					$file_no = upload_image($_FILES["file"], 7);

					if($file_no != ""){
						$set .= "`thumnail` = {$file_no},";
					}else{
						return_value(500, "파일업로드가 실패했습니다.");
					}
				}else{
					return_value(400, "이미지만 등록가능합니다.");
				}
			}else{
				if($board_id == "" && $board_type == 0){ // New인 경우에만 썸네일 체크함
					return_value(400, "썸네일이 등록되지 않았습니다.");
				}
			}
		}

		$except_key = ["flag", "b_type", "c_id", "b_id", "file"];

		foreach($_POST as $k => $v){
			if(in_array($k, $except_key) == false){
				$v = addslashes(htmlspecialchars($v));

				if($board_type != 2 && ($k == "answer_en" || $k == "answer_ko")){
					continue;
				}

				if(!$v || $v == "null" || $v == "" || $v == "undefined"){
					return_value(400, "필수 입력사항인 '{$k}'의 값이 없습니다.");
				}

				$set .= "`{$k}` = '{$v}',";
			}
		}

		
		if($board_id == "" && $board_type == 2){
			$set .= "`category` = {$category_id},";
		}

		$set = substr($set, 0, strlen($set)-1);

		if($board_id != ""){
			$sql = "
					UPDATE board
					SET
						modifier = {$user_idx},
						modify_date = NOW(),
						{$set}
					WHERE idx = {$board_id}
					";
		}else{
			$sql = "
					INSERT board
					SET
						`type` = {$board_type},
						register = {$user_idx},
						{$set}
					";
		}

		$res = sql_query($sql);
		
		if($res){
			return_value(200, "작성된 내용이 저장되었습니다.");
		}else{
			return_value(500, "데이터베이스 저장 실패.");
		}
	
	} else if($_POST["flag"] == "remove") {
		$user_idx = $_SESSION["ADMIN"]["idx"];

		// 로그인 유무 체크
		if($user_idx == ""){
			return_value(401, "로그인이 필요합니다.");
		}

		$board_id = isset($_POST["b_id"]) ? preg_replace("/[^0-9]/","",$_POST["b_id"]) : "";

		if($board_id == ""){
			return_value(400, "유효하지 않은 게시글 입니다.");
		}

		$sql = "
				UPDATE board
				SET
					modifier = {$user_idx},
					modify_date = NOW(),
					is_deleted = 'Y'
				WHERE idx = {$board_id}
				";

		$res = sql_query($sql);

		if($res){
			return_value(200, "삭제 처리 되었습니다.");
		}else{
			return_value(500, "데이터베이스 삭제 요청 거절.");
		}

	} else if($_POST["flag"] == "category_save"){

		$user_idx = $_SESSION["ADMIN"]["idx"];

		// 로그인 유무 체크
		if($user_idx == ""){
			return_value(401, "로그인이 필요합니다.");
		}

		$category_id = isset($_POST["c_id"]) ? preg_replace("/[^0-9]/","",$_POST["c_id"]) : "";
		
		$set = "";
		$except_key = ["flag", "c_id"];

		foreach($_POST as $k => $v){
			if(in_array($k, $except_key) == false){
				$v = addslashes(htmlspecialchars($v));

				if(!$v || $v == "null" || $v == "" || $v == "undefined"){
					return_value(400, "필수 입력사항인 '{$k}'의 값이 없습니다.");
				}

				$set .= "`{$k}` = '{$v}',";
			}
		}

		$set = substr($set, 0, strlen($set)-1);

		if($category_id != ""){
			$sql = "
					UPDATE board_category
					SET
						modifier = {$user_idx},
						modify_date = NOW(),
						{$set}
					WHERE idx = {$category_id}
					";
		}else{
			$sql = "
					INSERT board_category
					SET
						register = {$user_idx},
						{$set}
					";
		}

		$res = sql_query($sql);
		
		if($res){
			return_value(200, "작성된 내용이 저장되었습니다.");
		}else{
			return_value(500, "데이터베이스 저장 실패.");
		}

	}  else if($_POST["flag"] == "remove_category") {
		$user_idx = $_SESSION["ADMIN"]["idx"];

		// 로그인 유무 체크
		if($user_idx == ""){
			return_value(401, "로그인이 필요합니다.");
		}

		$category_id = isset($_POST["c_id"]) ? preg_replace("/[^0-9]/","",$_POST["c_id"]) : "";

		if($category_id == ""){
			return_value(400, "유효하지 않은 카테고리 입니다.");
		}

		$sql = "
				UPDATE board_category
				SET
					modifier = {$user_idx},
					modify_date = NOW(),
					is_deleted = 'Y'
				WHERE idx = {$category_id}
				";

		$res = sql_query($sql);

		if($res){
			return_value(200, "삭제 처리 되었습니다.");
		}else{
			return_value(500, "데이터베이스 삭제 요청 거절.");
		}

	}

	function return_value1($code, $msg){
		echo json_encode(array(
			"code"=>$code,
			"msg" =>$msg
		));
		exit;
	}
?>