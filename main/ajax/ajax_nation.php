<?php include_once("../common/common.php")?>
<?php
	if($_POST["flag"] == "nation_tel") {
		$nation_no = isset($_POST["nation"]) ? $_POST["nation"] : "";

		$select_nation_tel_query =	"
									SELECT
										nation_tel
									FROM nation
									WHERE idx = {$nation_no}
									";
		$nation_tel = sql_fetch($select_nation_tel_query)["nation_tel"];

		if($nation_tel != "") {
			echo json_encode(array(
				"code"=>200,
				"msg"=>"success",
				"tel"=>"+".$nation_tel
			));
			exit;
		} else {
			echo json_encode(array(
				"code"=>400,
				"msg"=>"error"
			));
			exit;
		}
	}

?>