<?php
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

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<style>
body {
	width : 100vw;
	height : 100vh;
	position : relative;
}
#spinner {
  min-width: 40px;
  min-height: 40px;
  border: 5px solid rgba(255,255,255,.1);
  border-right: 5px solid orange;
  border-radius: 50%;
  animation: spinner 1s linear infinite;
  position: absolute;
  left : 50%;
  top : 50%;
  transform : translate(-50%,-50%);
}
</style>
<body onload="javascript:loadForm();">
<div id="spinner"></div>
<?php
	//��ü �Ķ���� ���
	/*echo "--------all return parameter-------------<br/>";
	foreach($_POST as $Key=>$value) {
		echo $Key." : ".$value."<br/>" ; 
	}
	echo "----------------------------------------<br/>";*/
?>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type ="text/javascript">
<!--
	//openerâ�� ���� ���� �� ���� �� finish.php�� submit, ���� �˾� â close 
	function loadForm(){
		/*
		if(opener && opener.document.regForm){
			var frm = opener.document.regForm;
			frm.rescode.value = "<?php echo $rescode; ?>";
			frm.resmsg.value = "<?php echo $resmsg; ?>";			
			frm.target = "";
//			frm.action = "./registration3.php";
			frm.action = "./plugin/eximbay/finish.php";
			
			frm.submit();
		}
		*/
		$.ajax({
			url : "../../ajax/client/ajax_payment.php",
			type : "POST",
			data : {
				flag : "payment_eximbay",
				fgkey : "<?=$_POST['fgkey']?>", //���������ڵ�
				ref : "<?=$_POST['ref']?>", //������ȣ
				paymethod : "<?=$_POST['paymethod']?>", //��������(eximbay pdf ����)
				cur : "<?=$_POST['cur']?>", //��ȭ
				amt : "<?=$_POST['amt']?>", //�����ݾ�
				authcode : "<?=$_POST['authcode']?>", //���ι�ȣ
				resdt : "<?=$_POST['resdt']?>", //��������
				rescode : "<?=$_POST['rescode']?>", //�����ڵ�
				resmsg : "<?=$_POST['resmsg']?>" //����޼���
			}, 
			dataType : "JSON",	
			success : function(res) {
				if(res.code == 200) {
					// �θ�â ���� �Ϸ� �̺�Ʈ
					opener.move();
					self.close();
				} else if(res.code == 400) {
					self.close();
					opener.document.regForm.resmsg.value = "<?php echo $resmsg; ?>";
					opener.error();
				} else {
					self.close();
					opener.document.regForm.resmsg.value = "<?php echo $resmsg; ?>";
					opener.error();
				}
			}
		});

		// �θ�â ���� �Ϸ� �̺�Ʈ
		
	}
//-->
</script>
