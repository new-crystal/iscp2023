<?php
	include_once("../../common/common.php");
	/** 
		�Ʒ� ���� �� ���� �׽�Ʈ�� secretKey�Դϴ�.
		�׽�Ʈ�θ� �����Ͻð� �߱� ������ ������ �����ϼž� �˴ϴ�.
	*/
	$secretKey = "289F40E6640124B2628640168C3C5464";//������ secretkey

	foreach($_POST as $Key=>$value) {

		if($Key == "fgkey"){
			continue;
		}
		$hashMap[$Key]  = $value;
	}

	$rescode = $_POST['rescode'];//0000 : ���� 
	$resmsg = $_POST['resmsg'];//���� ��� �޼���
	$fgkey = $_POST['fgkey'];//���� fgkey

	//rescode=0000 �϶� fgkey Ȯ��
	if($rescode == "0000"){
		//fgkey ����Ű ����

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
		
		//fgkey ���� ���� �� ���� ó��
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
