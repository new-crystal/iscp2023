<?php
	
	//���� ���� �Ķ����
	$rescode = $_POST['rescode'];
	$resmsg = $_POST['resmsg'];	
	echo "rescode : ". $rescode . "<br/>";
	echo "resmsg : ". $resmsg . "<br/>";
	print_r($_POST);
?>
<html>
<body>
Done<br/>
<input type=button value="Retry" onclick="javascript:document.location.href='./registration.php';">
</body>
</html>