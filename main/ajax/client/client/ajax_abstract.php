<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// 리스트 가져오기
	if ($flag === "get_list") {

		$member_idx = isset($_SESSION["ADMIN"]["idx"]) ? $_SESSION["ADMIN"]["idx"] : $_SESSION["USER"]["idx"];

		$where = "";

		if ($_POST["keyword"] !== "") {
			switch($_POST["keyfield"]){
				case "title" :
					$where .= " AND ab.title LIKE '%".$_POST["keyword"]."%'";
					break;
				case "author" :
					$where .=	" AND (
									ab.author_name LIKE '%".$_POST["keyword"]."%'
									OR ab.author_affiliation LIKE '%".$_POST["keyword"]."%'
								)";
					break;
				case "code" :
					$where .= " AND ab.`code` LIKE '%".$_POST["keyword"]."%'";
					break;
			}
		}

		$sql =	"SELECT
					ab.idx,
					ab.`code`,
					ipac.rownum AS category_rownum,
					ab.category_idx,
					ab.title,
					ab.author_name,
					ab.author_affiliation,
					IFNULL(total_fv.cnt, 0) AS fave_count,
					IFNULL(total_rp.cnt, 0) AS reply_count,
					IF(my_fv.abstract_idx IS NOT NULL, 'Y', 'N') AS my_fave_yn
				FROM abstract AS ab
				LEFT JOIN (
					SELECT
						(@rownum:=@rownum+1) AS rownum, idx
					FROM info_poster_abstract_category, (SELECT @rownum:=0) TMP
					WHERE is_deleted = 'N'
					ORDER BY idx
				) AS ipac
					ON ipac.idx = ab.category_idx
				LEFT JOIN (
					SELECT
						abstract_idx, COUNT(idx) AS cnt
					FROM abstract_fave
					GROUP BY abstract_idx
				) AS total_fv
					ON total_fv.abstract_idx = ab.idx
				LEFT JOIN (
					SELECT
						abstract_idx, COUNT(idx) AS cnt
					FROM abstract_reply
					WHERE is_deleted = 'N'
					GROUP BY abstract_idx
				) AS total_rp
					ON total_rp.abstract_idx = ab.idx
				LEFT JOIN (
					SELECT DISTINCT
						abstract_idx
					FROM abstract_fave
					WHERE member_idx = '".$member_idx."'
				) AS my_fv
					ON my_fv.abstract_idx = ab.idx
				WHERE ab.is_deleted = 'N'
				".$where."
				ORDER BY ab.`code`
				";
		$list = get_data($sql);

		return_value(200, "완료되었습니다.", array("list"=>$list, "total_count"=>count($list)));
	}

	// 좋아요
	else if ($flag === "fave") {

		$type = "";
		$abstract_idx = $_POST["idx"];

		$is_admin = isset($_SESSION["ADMIN"]["idx"]);
		$member_idx = $is_admin ? $_SESSION["ADMIN"]["idx"] : $_SESSION["USER"]["idx"];

		$sql =	"SELECT
					COUNT(idx) AS cnt
				FROM abstract_fave
				WHERE abstract_idx = '".$abstract_idx."'
				AND member_idx = '".$member_idx."'";
		$exist = sql_fetch($sql)['cnt'] > 0;

		if (!$exist || $is_admin) { // insert
			$type = "ins";
			$sql =	"INSERT INTO
						abstract_fave
						(abstract_idx, member_idx)
					VALUES
						('".$abstract_idx."', '".$member_idx."')
					";
		} else { // delete
			$type = "del";
			$sql =	"DELETE FROM abstract_fave
					WHERE abstract_idx = '".$abstract_idx."'
					AND member_idx = '".$member_idx."'";
		}
		if (!sql_query($sql)) {
			return_value(500, "좋아요 처리 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
		} else {
			$sql_cnt =	"SELECT
							COUNT(idx) AS cnt
						FROM abstract_fave
						WHERE abstract_idx = '".$abstract_idx."'";
			$fave_count = sql_fetch($sql_cnt)['cnt'];

			return_value(200, "완료되었습니다.", array("type"=>$type, "current_count"=>$fave_count));
		}
	}

	// 댓글 - 리스트
	else if ($flag === "get_reply_list") {

		$where = "";

		$sql =	"SELECT
					rp.idx,
					DATE_FORMAT(rp.register_date, '%Y-%m-%d %H:%i') AS register_date,
					CONCAT(mb.first_name, ' ', mb.last_name) AS member_name,
					rp.contents,
					IF(rp.register_idx = '".$_SESSION["USER"]["idx"]."', 'Y', 'N') AS mine_yn
				FROM abstract_reply AS rp
				LEFT JOIN member AS mb
					ON mb.idx = rp.register_idx
				WHERE rp.is_deleted = 'N'
				AND rp.abstract_idx = '".$_POST['idx']."'
				".$where."
				ORDER BY rp.register_date
				";
		$list = get_data($sql);

		return_value(200, "완료되었습니다.", array("list"=>$list, "total_count"=>count($list)));
	}

	// 댓글 - 수정(+생성)
	else if ($flag === "modify_reply") {
		if ($_POST['reply_idx'] == "") {
			$sql =	"INSERT INTO
						abstract_reply
						(abstract_idx, register_idx, contents)
					VALUES
						('".$_POST['abstract_idx']."', '".$_SESSION["USER"]["idx"]."', '".$_POST['contents']."')
					";
		} else {
			$sql =	"UPDATE abstract_reply
					SET
						contents = '".$_POST['contents']."'
					WHERE idx = '".$_POST['reply_idx']."'
					";	
		}

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 댓글 - 삭제
	else if ($flag === "remove_reply") {
		$sql =	"UPDATE abstract_reply
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
?>