<?php
	/** 
		�Ʒ� ���� �� ���� �׽�Ʈ�� mid: 1849705C64 �� ���� secretKey �Դϴ�.
		�׽�Ʈ�θ� ���� �Ͻð� �߱� ������ ������ ���� �ϼž� �˴ϴ�.
	*/
	$secretKey = "289F40E6640124B2628640168C3C5464";//������ secretkey
	$reqURL = "https://secureapi.test.eximbay.com/Gateway/BasicProcessor.krp";//EXIMBAY TEST ���� ��û URL�Դϴ�.
	$fgkey = "";//fgkey����Ű ����
	$sortingParams = "";//�Ķ���� ���� ����

	foreach($_POST as $Key=>$value) {
		$hashMap[$Key]  = $value;
	}
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
	$fgkey = hash("sha256", $linkBuf);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body leftmargin="0" topmargin="0" align="center" onload="javascript:document.regForm.submit();">
<form name="regForm" method="post" action="<?php echo $reqURL; ?>">
<input type="hidden" name="fgkey" value="<?php echo $fgkey; ?>" />	<!--�ʼ� ��-->

<?php
foreach($_POST as $Key=>$value) {
?>
<input type="hidden" name="<?php echo $Key;?>" value="<?php echo $value;?>">
<?php } ?>
</form>
</body>
</html>

