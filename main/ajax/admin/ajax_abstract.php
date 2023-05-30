<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// 수정(+생성)
	if ($flag === "modify_abstract") {

		$abstract_idx = $_POST['idx'];
		$is_modify = !($abstract_idx == "");

		// 기존정보
		$sql_origin =	"SELECT * FROM abstract WHERE idx = '".$abstract_idx."'";
		$origin = sql_fetch($sql_origin);

		// 파일업로드 및 유효성 검사
		$file_poster = $is_modify ? $origin['poster_img'] : 0;
		if($_FILES["file_poster"]){
			$file_type = explode("/", $_FILES["file_poster"]["type"])[0];

			if($file_type == "image") {
				$_FILES["file_poster"]["name"] = htmlspecialchars($_FILES["file_poster"]["name"], ENT_QUOTES);
				$file_no = upload_image($_FILES["file_poster"], 0);

				if ($file_no != "" && $file_no > 0) {
					$file_poster = $file_no;
				} else {
					return_value(500, "파일업로드가 실패했습니다.");
				}
			} else {
				return_value(403, "이미지만 등록가능합니다.");
			}
		}
		$file_pdf = $is_modify ? $origin['pdf_img'] : 0;
		if($_FILES["file_pdf"]){
			$file_type = explode("/", $_FILES["file_pdf"]["type"])[1];

			if($file_type == "pdf") {
				$_FILES["file_pdf"]["name"] = htmlspecialchars($_FILES["file_pdf"]["name"], ENT_QUOTES);
				$file_no = upload_image($_FILES["file_pdf"], 0);

				if ($file_no != "" && $file_no > 0) {
					$file_pdf = $file_no;
				} else {
					return_value(500, "파일업로드가 실패했습니다.");
				}
			} else {
				return_value(403, "이미지만 등록가능합니다.");
			}
		}

		// 논문번호
		$code = $origin['code'];
		if ($origin['category_idx'] != $_POST['category']) {
			$sql_code_info =	"SELECT
									ab_ct.prefix,
									IFNULL(ab.cnt, 0) AS abstract_count
								FROM info_poster_abstract_category AS ab_ct
								LEFT JOIN (
									SELECT
										category_idx, COUNT(idx) AS cnt
									FROM abstract
									GROUP BY category_idx
								) AS ab
									ON ab.category_idx = ab_ct.idx
								WHERE ab_ct.idx = '".$_POST['category']."'";
			$code_info = sql_fetch($sql_code_info);
			$code = "ICOMES".date('Y')."-".$code_info['prefix']."-".sprintf('%06d', ($code_info['abstract_count']+1));
		}

		// abstract
		if (!$is_modify) {
			// 생성
			$sql =	"INSERT INTO
						abstract
						(code, category_idx, title, author_name, author_affiliation, poster_img, pdf_img)
					VALUES
						(
							'".$code."', 
							'".$_POST['category']."', 
							'".$_POST['title']."', 
							'".$_POST['name']."', '".$_POST['affiliation']."', 
							'".$file_poster."', '".$file_pdf."'
						)
					";
			if (!sql_query($sql)) {
				return_value(500, "Lecture 등록 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
			} else {
				$abstract_idx = sql_insert_id();
			}
		} else {
			// 수정
			$sql =	"UPDATE abstract
					SET
						code				= '".$code."',
						category_idx		= '".$_POST['category']."',
						title				= '".$_POST['title']."',
						author_name			= '".$_POST['name']."',
						author_affiliation	= '".$_POST['affiliation']."',
						poster_img			= '".$file_poster."',
						pdf_img				= '".$file_pdf."'
					WHERE idx = '".$abstract_idx."'";
			if (!sql_query($sql)) {
				return_value(500, "Lecture 수정 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
			}
		}

		return_value(200, "완료되었습니다.", array("idx"=>$abstract_idx));
	}

	// 삭제
	else if ($flag === "remove_abstract") {
		$sql =	"UPDATE abstract
				SET
					is_deleted = 'Y',
					delete_date = NOW()
				WHERE idx = '".$_POST['idx']."'
				";
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