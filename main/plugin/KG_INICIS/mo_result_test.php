<?php

    require_once('./libs/moProperties.php');
    $prop = new moProperties();

	try {
		$P_STATUS    = $_REQUEST["P_STATUS"];
		$P_RMESG1    = $_REQUEST["P_RMESG1"];
		$P_TID       = $_REQUEST["P_TID"];
		$P_REQ_URL   = $_REQUEST["P_REQ_URL"];
		$P_NOTI      = $_REQUEST["P_NOTI"];
		$P_AMT       = $_REQUEST["P_AMT"];

		if ($_REQUEST["P_STATUS"] === "00") {             // ������ P_STATUS===00 �� ��츸 ���� ��û

			$id_merchant = substr($P_TID,'10','10');     // P_TID �� MID ����
			$data = array(

				'P_MID' => $id_merchant,         // P_MID
				'P_TID' => $P_TID                // P_TID

			);

			//##########################################################################
			// ���ο�û API url (authUrl) ����Ʈ �� properties �� �����Ͽ� ����մϴ�.
			// idc_name ���� ���� ���� ���� ������ properties ���� include �Ͽ� ���ο�û�Ͻø� �˴ϴ�.
			//##########################################################################
			$idc_name 	= $_REQUEST["idc_name"];
			$P_REQ_URL  = $prop->getAuthUrl($idc_name);

			if (strcmp($P_REQ_URL, $_REQUEST["P_REQ_URL"]) == 0) {

				// curl ��� ����

				$ch = curl_init();                                                //curl �ʱ�ȭ
				curl_setopt($ch, CURLOPT_URL, $_REQUEST["P_REQ_URL"]);            //URL �����ϱ�
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                   //��û ����� ���ڿ��� ��ȯ
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);                     //connection timeout 10��
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);                      //���� ������ �������� ��ȿ���� �˻� ����
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));    //POST �� $data �� ����
				curl_setopt($ch, CURLOPT_POST, 1);                                //true�� post ����


				$response = curl_exec($ch);
				curl_close($ch);

				parse_str($response, $out);
				//print_r($out);

				//���� �κи�
				$tid				= @(in_array($out["P_TID"] , $out) ? $out["P_TID"] : "null" );						// �ŷ���ȣ
				$pay_method			= @(in_array($out["P_TYPE"] , $out) ? $out["P_TYPE"] : "null");						// �������(���Ҽ���)
				$result_code		= @(in_array($out["P_STATUS"] , $out) ? $out["P_STATUS"] : "null");					// ����ڵ�
				$result_msg			= @(in_array($out["P_RMESG1"] , $out) ? $out["P_RMESG1"] : "null");					// �������
				$total_price		= @(in_array($out["P_AMT"] , $out) ? $out["P_AMT"] : "null");						// �����Ϸ�ݾ�
				$moid				= @(in_array($out["P_OID"] , $out) ? $out["P_OID"] : "null");						// �ֹ���ȣ
				$payment_date			= @(in_array($out["P_AUTH_DT"] , $out) ? $out["P_AUTH_DT"] : "null");			// ���γ�¥
			}

			
		}

	} catch (Exception $e) {
		$s = $e->getMessage() . ' (�����ڵ�:' . $e->getCode() . ')';
		echo "<script>alert('����� ����'); return;</script>";
		exit;
	}
?>
<input type="hidden" name="tid"				value="<?=$tid?>"/>
<input type="hidden" name="moid"			value="<?=$moid?>"/>
<input type="hidden" name="method"			value="<?=$pay_method?>"/>
<input type="hidden" name="t_price"			value="<?=$total_price?>"/>
<input type="hidden" name="payment_date"	value="<?=$payment_date?>"/>

<script src="../../js/jquery-3.6.0.min.js"></script>
<!-- 230620 ���� icomes �ҽ��� �κ��̿���
gmail ���� �߼۵Ǵ� �κ��̿��� �ּ� �Ͽ����ϴ�
�ʿ��Ͻ� ��� �Ʒ� �ּ� ���� �� ������ �����Ͽ� ����Ͻø� �˴ϴ� -->
<script>
	var tid		= $("input[name=tid]").val();
	var moid	= $("input[name=moid]").val();
	var method	= $("input[name=method]").val();
	var price	= $("input[name=t_price]").val();
	var date	= $("input[name=payment_date]").val();

	$.ajax({
		url:"../../ajax/client/ajax_payment.php",
		type:"POST",
		data:{
			flag : "payment_inicis",
			type : 0,
			moid : moid,
			tid : tid,
			method : method,
			price : price,
			payment_date : date
		},
		dataType:"JSON",
		success : function(res){
			if(res.code == 200) {
			/*
				$.ajax({
					url : "../../ajax/client/ajax_gmail.php",
					type : "POST",
					data : {
						flag : "payment",
						name : res.name,
						email : res.email,
						data : res.data
					},
					dataType:"JSON"
				});
			*/
			}			
		},
		complete:function(){
			window.location.replace("../../registration3.php");
		}
	});
</script>