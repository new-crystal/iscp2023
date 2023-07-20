<?php include_once("../../common/common.php");?>
<?php
	if($_POST["flag"] == "application") {
		$user_idx = $_SESSION["USER"]["idx"];

		$sponsorship_package = isset($_POST["sponsorship_package"]) ? $_POST["sponsorship_package"] : "";
		$company_name = isset($_POST["company_name"]) ? $_POST["company_name"] : "";
		$ceo = isset($_POST["ceo"]) ? $_POST["ceo"] : "";
		$address = isset($_POST["address"]) ? $_POST["address"] : "";
		$website = isset($_POST["website"]) ? $_POST["website"] : "";
		$manager_first_name = isset($_POST["manager_first_name"]) ? $_POST["manager_first_name"] : "";
		$manager_last_name = isset($_POST["manager_last_name"]) ? $_POST["manager_last_name"] : "";
		$position = isset($_POST["position"]) ? $_POST["position"] : "";
		$email = isset($_POST["email"]) ? $_POST["email"] : "";
		$phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
		$mobile = isset($_POST["mobile"]) ? $_POST["mobile"] : "";

		$insert_query =	"
							INSERT request_application
							SET
								sponsorship_package = {$sponsorship_package},
								company_name = '{$company_name}',
								ceo = '{$ceo}',
								address = '{$address}',
								url = '{$website}',
								first_name = '{$manager_first_name}',
								last_name = '{$manager_last_name}',
								position = '{$position}',
								email = '{$email}',
								phone = '{$phone}',
								mobile = '{$mobile}',
								register_date = NOW()
						";

		if($_FILES["business_licence_file"]) {
			$licence_file_type = explode("/", $_FILES["business_licence_file"]["type"])[0];
			if($licence_file_type == "image") {
				$licence_file_no = upload_image($_FILES["business_licence_file"], 3);
			} else {
				$licence_file_no = upload_file($_FILES["business_licence_file"], 3);
			}

		}

		if($_FILES["signature_file"]) {
			$signature_file_type = explode("/", $_FILES["signature_file"]["type"])[0];
			if($signature_file_type == "image") {
				$signature_file_no = upload_image($_FILES["signature_file"],3);
			} else {
				$signature_file_no = upload_file($_FILES["signature_file"],3);
			}
			
		}
		
		if($licence_file_no && $signature_file_no) {
			$insert_query .= " , business_licence_file = {$licence_file_no} ";
			$insert_query .= " , signature_file = {$signature_file_no} ";
		} else {
			$res = [ code => 401 ];
			if(!$lience_file_no) {
				$res["msg"] = "licence file upload fail"; 
				echo json_encode($res);
				exit;
			} else if(!$signature_file_no) {
				$res["msg"] = "signature file upload fail"; 
				echo json_encode($res);
				exit;
			}
		}

		if($user_idx) {
			$insert_query .= ", register = {$user_idx} ";
		}

		$insert = sql_query($insert_query);
		
		if($insert) {
			$res = [
				code => 200,
				msg => "success"
			];
			echo json_encode($res);
			exit;
		} else {
			$res = [
				code => 400,
				msg => "application error"
			];
			echo json_encode($res);
			exit;
		}
	}
?>