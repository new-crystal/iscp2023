
<?php

/**
    아래 설정 된 값은 테스트용 mid: 1849705C64 에 대한 secretKey 입니다.
    테스트로만 진행 하시고 발급 받으신 값으로 변경 하셔야 됩니다.
 */
$mid = "1849705C64"; // 테스트 mid
// $mid = "189A6E05E4"; // 가맹점 mid
$secretKey = "289F40E6640124B2628640168C3C5464"; //테스트 secretkey
// $secretKey = "304FD62FE40340F5593E40397840F1E4"; //가맹점 secretkey
$reqURL = "https://secureapi.test.eximbay.com/Gateway/BasicProcessor.krp"; //EXIMBAY TEST 서버 요청 URL입니다.
// $reqURL = "https://secureapi.eximbay.com/Gateway/BasicProcessor.krp";//EXIMBAY 실 서버 요청 URL입니다.
$fgkey = ""; //fgkey검증키 관련
$sortingParams = ""; //파라미터 정렬 관련

foreach ($_POST as $Key => $value) {
	$hashMap[$Key]  = $value;
}
$size = count($hashMap);
ksort($hashMap);
$counter = 0;
foreach ($hashMap as $key => $val) {
	if ($counter == $size - 1) {
		$sortingParams .= $key . "=" . $val;
	} else {
		$sortingParams .= $key . "=" . $val . "&";
	}
	++$counter;
}

$linkBuf = $secretKey . "?" . $sortingParams;
$fgkey = hash("sha256", $linkBuf);

?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" align="center" onload="javascript:document.regForm.submit();">
	<form name="regForm" method="post" action="<?php echo $reqURL; ?>">
		<input type="hidden" name="fgkey" value="<?php echo $fgkey; ?>" />
		<!--필수 값-->

		<?php
		foreach ($_POST as $Key => $value) {
		?>
			<input type="hidden" name="<?php echo $Key; ?>" value="<?php echo $value; ?>">
		<?php } ?>
	</form>
</body>


</html>