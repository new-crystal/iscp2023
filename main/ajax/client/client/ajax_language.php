<?php include_once("../../common/common.php");?>
<?php
	
	if($_POST["language"] == "ko") {
		$_SESSION["language"] = "ko";
		echo 1;
		exit;
	} else if($_POST["language"] == "en") {
		$_SESSION["language"] = "en";
		echo 1;
		exit;
	} else {
		echo json_encode(array(
					"code"=>400,
					"msg"=>"error"
			));
		exit;
	}	
?>