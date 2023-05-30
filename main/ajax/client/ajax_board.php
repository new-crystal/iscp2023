<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	if($flag == "file_view") {

		$idx = $_POST['idx'];
	
		$sql="UPDATE
				board
			SET
				file_view = file_view+1
			WHERE idx = {$idx}
		";

		sql_query($sql);
		return_value(200, "완료되었습니다.");
	}
?>