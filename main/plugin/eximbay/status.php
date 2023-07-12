<?php
	include_once("../../common/common.php");
	/**
	아래 설정 된 값은 테스트용 secretKey입니다.
	테스트로만 진행하시고 발급 받으신 값으로 변경하셔야 됩니다.
	 */
	$secretKey = "289F40E6640124B2628640168C3C5464";//������ secretkey

	foreach($_POST as $Key=>$value) {

		if($Key == "fgkey"){
			continue;
		}
		$hashMap[$Key]  = $value;
	}

	$rescode = $_POST['rescode'];//0000 : 정상
	$resmsg = $_POST['resmsg'];//결제 결과 메세지
	$fgkey = $_POST['fgkey'];//검증 fgkey

	//rescode=0000 일때 fgkey 확인
	if($rescode == "0000"){
		//fgkey 검증키 생성

		$size = count($hashMap);
		ksort($hashMap);
		$counter = 0;
		foreach ($hashMap as $key => $val) {
			if ($counter == $size-1){
				$sortingParams .= $key."=" .$val;
			}else{
				$sortingParams .= $key."=" .$val."&";
			}
			++$counter;
		}
		//echo $sortingParams;
		
		$linkBuf = $secretKey. "?".$sortingParams;
		$newFgkey = hash("sha256", $linkBuf);

		//fgkey 검증 실패 시 에러 처리
		if(strtolower($fgkey) != $newFgkey){
			$rescode = "ERROR";
			$resmsg = "Invalid transaction";
		}
		
	}

	if($rescode == "0000"){
		//������ �� DB ó���ϴ� �κ�
		//�ش� �������� Back-End�� ó���Ǳ� ������ ��ũ��Ʈ, ����, ��Ű ����� �Ұ��� �մϴ�.
		
	}
?>
