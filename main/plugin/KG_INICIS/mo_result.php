
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

		if ($_REQUEST["P_STATUS"] === "00") {             // 인증이 P_STATUS===00 일 경우만 승인 요청

			$id_merchant = substr($P_TID,'10','10');     // P_TID 내 MID 구분
			$data = array(

				'P_MID' => $id_merchant,         // P_MID
				'P_TID' => $P_TID                // P_TID

			);

			//##########################################################################
			// 승인요청 API url (authUrl) 리스트 는 properties 에 세팅하여 사용합니다.
			// idc_name 으로 수신 받은 센터 네임을 properties 에서 include 하여 승인요청하시면 됩니다.
			//##########################################################################
			$idc_name 	= $_REQUEST["idc_name"];
			$P_REQ_URL  = $prop->getAuthUrl($idc_name);

			if (strcmp($P_REQ_URL, $_REQUEST["P_REQ_URL"]) == 0) {

				// curl 통신 시작

				$ch = curl_init();                                                //curl 초기화
				curl_setopt($ch, CURLOPT_URL, $_REQUEST["P_REQ_URL"]);            //URL 지정하기
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                   //요청 결과를 문자열로 반환
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);                     //connection timeout 10초
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);                      //원격 서버의 인증서가 유효한지 검사 안함
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));    //POST 로 $data 를 보냄
				curl_setopt($ch, CURLOPT_POST, 1);                                //true시 post 전송


				$response = curl_exec($ch);
				curl_close($ch);

				parse_str($response, $out);
				//print_r($out);

				//공통 부분만
				$tid				= @(in_array($out["P_TID"] , $out) ? $out["P_TID"] : "null" );						// 거래번호
				$pay_method			= @(in_array($out["P_TYPE"] , $out) ? $out["P_TYPE"] : "null");						// 결제방법(지불수단)
				$result_code		= @(in_array($out["P_STATUS"] , $out) ? $out["P_STATUS"] : "null");					// 결과코드
				$result_msg			= @(in_array($out["P_RMESG1"] , $out) ? $out["P_RMESG1"] : "null");					// 결과내용
				$total_price		= @(in_array($out["P_AMT"] , $out) ? $out["P_AMT"] : "null");						// 결제완료금액
				$moid				= @(in_array($out["P_OID"] , $out) ? $out["P_OID"] : "null");						// 주문번호
				$payment_date			= @(in_array($out["P_AUTH_DT"] , $out) ? $out["P_AUTH_DT"] : "null");			// 승인날짜
			}

			
		}

	} catch (Exception $e) {
		$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
		echo "<script>alert('모바일 오류'); return;</script>";
		exit;
	}
?>
<input type="hidden" name="tid"				value="<?=$tid?>"/>
<input type="hidden" name="moid"			value="<?=$moid?>"/>
<input type="hidden" name="method"			value="<?=$pay_method?>"/>
<input type="hidden" name="t_price"			value="<?=$total_price?>"/>
<input type="hidden" name="payment_date"	value="<?=$payment_date?>"/>

<script src="../../js/jquery-3.6.0.min.js"></script>
<!-- 230620 기존 icomes 소스인 부분이여서
gmail 메일 발송되는 부분이여서 주석 하였습니다
필요하신 경우 아래 주석 해제 후 데이터 가공하여 사용하시면 됩니다 -->
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