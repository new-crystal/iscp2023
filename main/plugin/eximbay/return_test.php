
<?php

/**
    아래 설정 된 값은 테스트용 secretKey입니다.
    테스트로만 진행하시고 발급 받으신 값으로 변경하셔야 됩니다.
 */
$secretKey = "289F40E6640124B2628640168C3C5464"; // 테스트 secretkey
//$secretKey = "304FD62FE40340F5593E40397840F1E4"; //가맹점 secretkey

foreach ($_POST as $Key => $value) {

	if ($Key == "fgkey") {
		continue;
	}
	$hashMap[$Key]  = $value;
}

$rescode = $_POST['rescode']; //0000 : 정상
$resmsg = $_POST['resmsg']; //결제 결과 메세지
$fgkey = $_POST['fgkey']; //검증 fgkey

//rescode=0000 일때 fgkey 확인
if ($rescode == "0000") {
	//fgkey 검증키 생성

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
	//echo $sortingParams;

	$linkBuf = $secretKey . "?" . $sortingParams;
	$newFgkey = hash("sha256", $linkBuf);

	//fgkey 검증 실패 시 에러 처리
	if (strtolower($fgkey) != $newFgkey) {
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
    width: 100vw;
    height: 100vh;
    position: relative;
}

#spinner {
    min-width: 40px;
    min-height: 40px;
    border: 5px solid rgba(255, 255, 255, .1);
    border-right: 5px solid orange;
    border-radius: 50%;
    animation: spinner 1s linear infinite;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}
</style>

<body onload="javascript:loadForm();">
    <div id="spinner"></div>
    <?php
	//전체 파라미터 출력
	/*echo "--------all return parameter-------------<br/>";
	foreach($_POST as $Key=>$value) {
		echo $Key." : ".$value."<br/>" ; 
	}
	echo "----------------------------------------<br/>";*/
	?>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
//opener창에 결제 응답 값 세팅 후 finish.php로 submit, 현재 팝업 창 close
function loadForm() {
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
        url: "../../ajax/client/ajax_payment_test.php",
        type: "POST",
        data: {
            flag: "payment_eximbay",
            fgkey: "<?= $_POST['fgkey'] ?>", //결제고유코드
            ref: "<?= $_POST['ref'] ?>", //결제번호
            paymethod: "<?= $_POST['paymethod'] ?>", //결제종류(eximbay pdf 참조)
            cur: "<?= $_POST['cur'] ?>", //통화
            amt: "<?= $_POST['amt'] ?>", //결제금액
            authcode: "<?= $_POST['authcode'] ?>", //승인번호
            resdt: "<?= $_POST['resdt'] ?>", //결제일자
            rescode: "<?= $_POST['rescode'] ?>", //응답코드
            resmsg: "<?= $_POST['resmsg'] ?>" //응답메세지
        },
        dataType: "JSON",
        success: function(res) {
            if (res.code == 200) {
                payment_ajax(res.name, res.email, res.data, res.flag);

                // 부모창 결제 완료 이벤트
                self.close();
            } else if (res.code == 400) {
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

    // 부모창 결제 완료 이벤트

}

/*
 * 230711 HUBDNC 메일 발송하는 부분 추가
 */
function payment_ajax(name, email, data, flag) {
    $.ajax({
        url: "../../ajax/client/ajax_gmail.php",
        type: "POST",
        data: {
            flag: "payment_mail",
            name: name,
            email: email,
            data: data
        },
        dataType: "JSON",
        success: function(res) {

        },
        complete: function() {
            window.opener.location.href = "../../registration3.php";
        }
    });
}

</script>