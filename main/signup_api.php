<?php include_once("./common/common.php");?>
<?php include_once("./common/locale.php");?>
<?php


 try {
		   $data = array(
				'id' => $_POST['id'],
				'password' => urlencode($_POST['password'])
			);

		$select_sql = "SELECT
							ksola_member_check
						FROM member
						WHERE ksola_member_check = '".$data['id']."'";

		  $check_id = sql_fetch($select_sql)['ksola_member_check'];

		  if(!empty($check_id)) {
			return_value(200, "ok", ["value" => '{"msg":"N6"}']);
		  }
		 
		  $url = "https://www.lipid.or.kr/user_jason.php?id=".$data['id']."&password=".$data['password'];
		 
		  $is_post = false;
		  $method = "GET";
		 
		  /*
		  curl = 원하는 url에 값을 넣고 리턴되는 값을 받아오는 함수
		  */
		  $ch = curl_init(); //세션 초기화
		 
		  /*curl_setopt : curl옵션 세팅
			CURLOPT_URL : 접속할 url
			CURLOPT_POST : 전송 메소드 Post
			CURLOPT_RETURNTRANSFER : 리턴 값을 받음
		  */
		  curl_setopt($ch, CURLOPT_URL, $url);

		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		  curl_setopt($ch, CURLOPT_POST, true);
		 

		/*
		  curl_exec : 실행
		  curl_getinfo : 전송에 대한 정보
		  CURLINFO_HTTP_CODE : 마지막 HTTP 코드 수신
		*/
		  $response = curl_exec ($ch);
		  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		 
		  curl_close ($ch);
		  if($status_code == 200) { //정상
			//echo $response;
			return_value(200, "ok", ["value" => $response, "ksola_member_check" => $data['id']]);
		  }
		  
		  else {
			echo "Error 내용: ".$response;
		  }

 } catch(\Throwable $tw) {
	return_value("저장하는 중 오류가 발생했습니다.", ['error' => $tw->getMessage()]);
 }
 return_value(200, 'ok');

  
 
  ?>

