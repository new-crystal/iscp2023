<?php
	include_once("../../common/common.php");
	include_once('../../include/invited_speaker_data.php');

	$flag = $_POST["flag"] ?? $_GET["flag"];

	if($flag == "invited_speaker") {

		$first_word = $_POST["first_word"] ?? null;
		$session_word = $_POST["session_word"] ?? null;
		$search_word = $_POST["search_word"] ?? null;
		$order = $_POST["order"] ?? null;
		$category_bool = $_POST["category_bool"] ?? null;
		//order을 넣은 이유는 가장 늦게 선택한 걸 마지막에 걸러주려고

		$list = $invited_speaker_list;


		//session 여부
		if($category_bool == "true") {
			array_splice($list, 75, 1);
		} else {
			array_splice($list, 76, 2);
		}
			
		if($order == 1) {
		
			if(!empty($session_word)) {
				$list = session_forder($list, $session_word);
			}
			if(!empty($search_word)) {
				$list = search_forder($list, $search_word);
			}
			if(!empty($first_word)) {
				$list = first_order($list, $first_word);
			}
			
		}
		else if($order == 2) {

			if(!empty($first_word)) {
				$list = first_order($list, $first_word);
			}
			if(!empty($search_word)) {
				$list = search_forder($list, $search_word);
			}
			if(!empty($session_word)) {
				$list = session_forder($list, $session_word);
			}
			
		}
		else if($order == 3) {

			if(!empty($first_word)) {
				$list = first_order($list, $first_word);
			}
			if(!empty($session_word)) {
				$list = session_forder($list, $session_word);
			}
			if(!empty($search_word)) {
				$list = search_forder($list, $search_word);
			}
		}
		return_value(200, "완료되었습니다.", array("list"=>$list, "total_count"=>count($list)));
	}

	function first_order($list, $first_word) {
		$list_value = array();
		foreach($list as $l) {
			$last_name = substr($l["last_name"], 0, 1);

			if($first_word == $last_name) {
				$list_value[] = $l;
			}
		}
		return $list_value;
	}
	function session_forder($list, $session_word) {
		
		$list_value = array();

		foreach($list as $l) {
			$session_type = $l["session_type"];
			$joint = $l["joint"];

			if(strrpos($session_type, $session_word) !== false || strrpos($joint, $session_word) !== false) {
				$list_value[] = $l;
			} else {
				if($l["idx"] == 71) {
					$session_type2 = $l["session_type2"];
					if(strrpos($session_type2, $session_word) !== false || strrpos($joint, $session_word) !== false) {
						$list_value[] = $l;
					}
				}
			}
			
		}
		return $list_value;
	}
	function search_forder($list, $search_word) {
		$list_value = array();

		$search_word = strtolower($search_word);
	
		foreach($list as $l) {
			$first_name =strtolower($l["first_name"]);
			$last_name = strtolower($l["last_name"]);

			$name = $first_name." ".$last_name;

			$affiliation = strtolower($l["affiliation"]);
			$nation = strtolower($l["nation"]);
			$session_type = strtolower($l["session_type"]);
			$title = strtolower($l["title"]);
			
			if(strrpos($name, $search_word) !== false || strrpos($affiliation, $search_word) !== false || strrpos($nation, $search_word) !== false || strrpos($title, $search_word) !== false || strrpos($session_type, $search_word) !== false) {
				$list_value[] = $l;
			} else {
				if($l["idx"] == 71) {
					$session_type2 = $l["session_type2"];
					$title2 = strtolower($l["title2"]);
					if(strrpos($session_type2, $search_word) !== false || strrpos($title2, $search_word) !== false) {
						$list_value[] = $l;
					}
				}
			}
		}
		return $list_value;
	}


?>