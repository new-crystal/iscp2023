<?php
	
	//���� ���� �Ķ����
	$rescode = $_POST['rescode'];
	$resmsg = $_POST['resmsg'];	
	echo "rescode : ". $rescode . "<br/>";
	echo "resmsg : ". $resmsg . "<br/>";
?>
<html>
<body>
Done<br/>
<input type=button value="Retry" onclick="javascript:document.location.href='payment.html';">
</body>
</html>