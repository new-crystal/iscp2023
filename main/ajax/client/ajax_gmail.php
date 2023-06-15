<?php include_once("../../common/common.php"); ?>
<?php include_once("../../common/locale.php"); ?>

<?php
include_once('../../../../icomes.or.kr/main/plugin/google-api-php-client-main/vendor/autoload.php');

$language = isset($_SESSION["language"]) ? $_SESSION["language"] : "en";
$locale = locale($language);

if (php_sapi_name() != 'cli') {
	//throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
	$client = new Google_Client();
	$client->setApplicationName('Gmail API PHP Quickstart');
	//$client->setScopes(Google_Service_Gmail::GMAIL_READONLY);
	// 23.06.02 HUBDNC_NYM ICSP용으로 URL변경
	$client->setAuthConfig('../../../../icomes.or.kr/main/plugin/google-api-php-client-main/iscp_credentials.json');
	$client->setIncludeGrantedScopes(true);
	$client->setAccessType('offline');
	$client->setPrompt('select_account consent');

	$redirect_uri = "https://iscp2023.org/main/ajax/client/ajax_gmail.php";
	$client->setRedirectUri($redirect_uri);

	$client->addScope('https://www.googleapis.com/auth/gmail.readonly');
	$client->addScope('https://www.googleapis.com/auth/gmail.modify');
	$client->addScope('https://mail.google.com/');

	// Load previously authorized token from a file, if it exists.
	// The file token.json stores the user's access and refresh tokens, and is
	// created automatically when the authorization flow completes for the first
	// time.
	$tokenPath = 'token.json';
	if (file_exists($tokenPath)) {
		$accessToken = json_decode(file_get_contents($tokenPath), true);
		$client->setAccessToken($accessToken);
	}

	// If there is no previous token or it's expired.
	if ($client->isAccessTokenExpired()) {
		// Refresh the token if possible, else fetch a new one.
		if ($client->getRefreshToken()) {
			$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
		} else {
			// Request authorization from the user.
			$authUrl = $client->createAuthUrl();
			//printf("Open the following link in your browser:\n%s\n", $authUrl);
			//print 'Enter verification code: ';
			$authCode = trim(fgets(STDIN));

			// Exchange authorization code for an access token.
			$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
			$client->setAccessToken($accessToken);

			// Check to see if there was an error.
			if (array_key_exists('error', $accessToken)) {
				throw new Exception(join(', ', $accessToken));
			}
		}
		// Save the token to a file.
		if (!file_exists(dirname($tokenPath))) {
			mkdir(dirname($tokenPath), 0700, true);
		}
		file_put_contents($tokenPath, json_encode($client->getAccessToken()));
	}
	return $client;
}


// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Gmail($client);

// Print the labels in the user's account.
$user = 'secretariat@iscp2023.org';
$results = $service->users_labels->listUsersLabels($user);

if (count($results->getLabels()) == 0) {
	//print "No labels found.\n";
} else {
	//print "Labels:\n";
	foreach ($results->getLabels() as $label) {
		//printf("- %s\n", $label->getName());
	}
}

function createMessage($language, $mail_type, $fname, $to, $subject, $time, $tmp_password, $callback_url, $type = 0, $file = "", $cc = "", $bcc = "", $id = "", $date = "", $category = "", $title = "")
{
	$message = new Google_Service_Gmail_Message();

	$rawMessageString = "From: ISCP<secretariat@iscp2023.org>\r\n";
	$rawMessageString .= "To: <{$to}>\r\n";
	$rawMessageString .= 'Subject: =?utf-8?B?' . base64_encode($subject) . "?=\r\n";
	$rawMessageString .= "MIME-Version: 1.0\r\n";
	$rawMessageString .= "Content-Type: text/html; charset=utf-8\r\n";
	$rawMessageString .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";


	if ($mail_type == "signup_join") {
		$rawMessageString .= "
		<table width='750' style='border:1px solid #000; border-radius:27px 27px 0 0; padding: 0;'>
			<tbody>
				<tr>
					<td colspan='3'>
						<img src='https://iscp2023.org/main/img/mail_header.png' width='750' style='width:750px;'>
					</td>
				</tr>
				<tr>
					<td colspan='3'>
						<div style='font-weight:bold; text-align:center;font-size: 21px; color: #00666B;padding: 20px 0;'>[ISCP 2023] Welcome to ISCP 2023!</div>
					</td>
				</tr>
				<tr>
					<td width='74' style='width:74px;'></td>
					<td>
						<div>
							<p style='font-size:15px; font-weight:bold; color:#000; margin:0;'>Dear {$fname},</p>
							<p style='font-size:14px;color:#170F00;margin-top:14px;'>Thank you for signing up for the ISCP 2023.<br>Your profile has been successfully created.<br>Please review the information that you have entered as below.<br>If necessary, you can access ISCP 2023 website - MY PAGE’ to review, modify or update your personal information.</p>
							<table width='586' style='width:586px; border-collapse:collapse; border-top:2px solid #000; width:100%; margin:17px 0;'>
								<tbody>
									<tr>
										<th style='width:150px; text-align:left; font-size:14px; padding:10px; border-bottom:1px solid #000;'>ID (Email Address)</th>
										<td colspan='2' style='font-size:14px; padding:10px; border-left:1px solid #000; border-bottom:1px solid #000;'><a href='mailto:{$to}' class='link font_inherit'>{$to}</a></td>
									</tr>
									<tr>
										<th style='width:150px; text-align:left; font-size:14px; padding:10px; border-bottom:1px solid #000;'>Name</th>
										<td colspan='2' style='font-size:14px; padding:10px; border-left:1px solid #000; width:165px; border-bottom:1px solid #000;'>{$fname}</td>
										
									</tr>
									
								</tbody>	
							</table>
							<p>We express our gratitude to you for your interest in ISCP 2023.</p>
						</div>
					</td>
					<td width='74' style='width:74px;'></td>
				</tr>
				<tr>
					<td width='74' style='width:74px;'></td>
					<td style='padding-top:16px;'>
						<p>Warmest regards, ISCP</p>
						<div style='text-align: center;'>
						<a href='https://iscp2023.org/main/login.php' style='cursor: pointer;' target='_blank'><img src='https://iscp2023.org/main/img/mail_button.png' style='display:block; margin:0 auto; width:250px;'></a>
						</div>
					</td>
					<td width='74' style='width:74px;'></td>
				</tr>
				<tr>
					<td colspan='3' style='padding-top:50px;'>
						<img src='https://iscp2023.org/main/img/mail_footer.png' width='750' style='width:750px;'>
					</td>
				</tr>
			</tbody>
		</table>

";
	} else if ($mail_type == "abstract") {
		$rawMessageString .= "
					<div style='width:670px;background-color:#fff;border:1px solid #000; font-size:0;'>
						<img src='https://iscp2023.org/main/img/mail_header.png' style='width:100%; margin:0;'>
						<div style='width:100%;margin:0 0 60px 0;background-color:#00666B;text-align:center;font-size: 21px; color: #FFF;padding: 10px 0;'>[ISCP 2023 with APSAVD] Abstract Successfully Submitted</div>	
						<div style='padding:0 40px;'>
							<div style='margin-bottom:25px; background-color:#F8F8F8;border-top:2px solid #707070; padding:17px 34px; box-sizing:border-box;'>
								<div style='margin-bottom:40px;'>
									<p style='font-size:15px; font-weight:bold; color:#000; margin:0;'>Dear {$fname}</p>
									<p style='font-size:14px;color:#170F00;margin-top:14px;'>
										Attention Potential Presenting Author: Upon successful submission of your abstract, you will immediately see the following confirmation notice on your screen, followed by the same message via e&#45;mail. If you did not receive the following message, your abstract was not successfully submitted. Please try again, or contact (iscp@into-on.com) for assistance if you are having difficulty. 
										<br>
										The deadline for abstract submissions is September 5 (submissions close at 11:59pm Korea Standard Time). It is your responsibility to address questions about submissions before September 5, so that if there is a problem, we can still help you make the submission on time. Be sure to print and/or save the confirmation of submission notices for reference in case of a problem or question.
										</p>

									<p style='font-size:15px; font-weight:bold; color:#000; margin-top:30px;'>Abstract Successfully Submitted</p>
									<p style='font-size:14px; color:#170F00; margin-top:14px;'>This is an automated message. Please do not reply</p>
									<ul style='list-style:none; padding-left:10px;'>
										<li style='font-size:14px; font-weight:bold; color:#000'>ID : <span style='font-size:14px; font-weight:400; color:#000;'>[{$to}]</span></li>
										<li style='font-size:14px; font-weight:bold; color:#000'>Submission date : <span style='font-size:14px; font-weight:400; color:#000;'>{$date}</span></li>
										<li style='font-size:14px; font-weight:bold; color:#000'>Topic : <span style='font-size:14px; font-weight:400; color:#000;'>{$category}</span></li>
										<li style='font-size:14px; font-weight:bold; color:#000'>Abstract title : <span style='font-size:14px; font-weight:400; color:#000;'>{$title}</span></li>
									</ul>
									<p style='font-size:14px;color:#170F00;margin-top:14px;'>If you have any questions regarding call for abstracts, please contact the secretariat (<a href='mailto:iscp@into-on.com)'>iscp@into-on.com</a>)</p>
									<p style='font-size:14px;color:#170F00;margin-top:14px;'>We look forward to seeing you in ISCP 2023.</p>
									<p style='font-size:14px;color:#170F00;margin-top:14px;'>Warmest regards,</p>
									<p style='font-size:14px;color:#170F00;margin-top:14px;'>ISCP 2023 Secretariat. </p>
								</div>
							</div>
							<div style='text-align: center;'>
								<a href='https://iscp2023.org/main/login.php' style='cursor: pointer;' target='_blank'><img src='https://iscp2023.org/main/img/mail_button.png' style='display:block; margin:0 auto;  width:250px;'></a>
							</div>
						</div>
						<img src='https://iscp2023.org/main/img/mail_footer.png' style='width:100%;margin-top:40px;'>
					</div>
					";
	}

	if ($language == "ko") {
		if ($mail_type == "find_password") {
			$rawMessageString .= "
						<div style='width:670px;background-color:#fff;border:1px solid #000; padding:0 40px;'>
							<img src='https://iscp2023.org/main/img/mail_header.png' style='width:calc(100% + 80px);margin-left:-40px;'>
							<img src='https://iscp2023.org/main/img/mail_header_bom.png' style='width:calc(100% + 80px);margin-left:-40px;margin-bottom:60px;'>
							<div>
								<div style='margin-bottom:25px; background-color:#F8F8F8;border-top:2px solid #707070; padding:17px 34px; box-sizing:border-box;'>
									<div style='margin-bottom:40px;'>
										<p style='font-size:15px; font-weight:bold; color:#000; margin:0;'>member of {$fname}, <br>You requested a temporary password at {$time}</p>
										<p style='font-size:14px;color:#AAAAAA;margin-top:14px;'>(If you have never requested a temporary password, please delete the email.)</p>
										<p style='font-size:14px;color:#170F00;margin-top:30px;'>Since our site does not have your password even if you are an administrator,<br>
										Instead of giving you your password, we're creating a new one and guiding you.<br>Check the password below to change.</p>
										<p style='font-size:14px;color:#FF0000;margin-top:14px;'>Click the Change to temporary password button.</p>
										<p style='font-size:14px;color:#170F00;margin-top:30px;'>When an authentication message is printed stating that the password has been changed,<br>
										Please enter your member ID and changed password on the homepage and log in.</p>
										<p style='font-size:14px;color:#AAAAAA;margin-top:14px;'>After logging in, please change to a new password from the Modify Information menu.</p>
										<p style='font-size:13px;color:#170F00;margin-top:20px;margin-bottom:5px;'>Member ID<span style='font-size:14px;color:#170F00;margin-left:5px;'>{$to}</span></p>
										<p style='font-size:13px;color:#170F00;margin-top:0px;'>Temporary password<span style='font-size:14px;color:#170F00;margin-left:5px;'>{$tmp_password}</span></p>
										<p style='font-size:14px;color:#170F00;margin-top:40px;'>Regards, <br> ISCP</p>
									</div>
								</div>
								<!-- <p style='padding-left:60px;text-align:left;font-size:15px;color:#170F00;line-height:1.8;'>Member of mini, <br>You requested a temporary password at 2022-04-07 18:30:08</p> -->
								<!-- <p style='padding-left:60px;text-align:left;font-size:12px;color:#AAAAAA;margin-top:22px;'>(If you have never requested a temporary password, please delete the email.)</p> -->
								<!-- <p style='padding-left:60px;text-align:left;font-size:12px;color:#170F00;margin-top:42px;line-height:1.8;'>Since our site does not have your password even if you are an administrator,<br> -->
								<!-- Instead of giving you your password, we're creating a new one and guiding you.<br>Check the password below to change.</p> -->
								<!-- <p style='padding-left:60px;font-size:13px;color:#FF0000;margin-top:17px;'>Click the Change to temporary password button.</p> -->
								<!-- <p style='padding-left:60px;text-align:left;font-size:12px;color:#170F00;margin-top:42px;line-height:1.8;'>When an authentication message is printed stating that the password has been changed,<br> -->
								<!-- Please enter your member ID and changed password on the homepage and log in.</p> -->
								<!-- <p style='padding-left:60px;text-align:left;font-size:12px;color:#AAAAAA;margin-top:17px;'>After logging in, please change to a new password from the Modify Information menu.</p> -->
								<!-- <p style='padding-left:60px;text-align:left;font-size:13px;color:#170F00;margin-top:32px;'>Member ID<span style='text-align:left;font-size:14px;color:#170F00;margin-left:5px;'>icomes@naver.com</span></p> -->
								<!-- <p style='padding-left:60px;text-align:left;font-size:13px;color:#170F00;margin-top:11px;'>Temporary password<span style='text-align:left;font-size:14px;color:#170F00;margin-left:5px;'>123456789</span></p> -->
								<!-- <p style='padding-left:60px;text-align:left;font-size:14px;color:#170F00;margin-top:51px;'>Regards, <br> ISCP</p> -->
								
								<a href='https://iscp2023.org/main/login.php' style='cursor: pointer;' target='_blank'><img src='https://iscp2023.org/main/img/mail_button.png' style='display:block; margin:0 auto;'></a>
							
							</div>
							<!-- <a href='{$callback_url}' style='display:block;text-decoration:none;text-align:center;width:180px;max-width:180px;background:#fff;margin-left:60px;border:1px solid #585859;border-radius:30px;padding:14px 50px;background:#fff;cursor:pointer;color:#000;'>Change to temporary password</a> -->
							<img src='https://iscp2023.org/main/img/mail_footer.png' style='width:calc(100% + 80px);margin-left:-40px;margin-top:40px;'>
						</div>
						";
		}
	} else {
		if ($mail_type == "find_password") {
			$rawMessageString .= "<div style='width:670px;background-color:#fff;border:1px solid #000;'><img src='https://iscp2023.org/main/img/mail_header.png' style='width:100%;'><img src='https://iscp2023.org/main/img/mail_header_bom.png' style='width:100%; margin-bottom:60px;'><div style='padding:0 40px'><div style='margin-bottom:25px; background-color:#F8F8F8;border-top:2px solid #707070; padding:17px 34px; box-sizing:border-box;'><div style='margin-bottom:40px;'><p style='font-size:15px; font-weight:bold; color:#000; margin:0;'>member of {$fname}, <br>You requested a temporary password at {$time}</p><p style='font-size:14px;color:#AAAAAA;margin-top:14px;'>(If you have never requested a temporary password, please delete the email.)</p><p style='font-size:14px;color:#170F00;margin-top:30px;'>Since our site does not have your password even if you are an administrator,<br>Instead of giving you your password, we're creating a new one and guiding you.<br>Check the password below to change.</p><p style='font-size:14px;color:#FF0000;margin-top:14px;'>Click the Change to temporary password button.</p><p style='font-size:14px;color:#170F00;margin-top:30px;'>When an authentication message is printed stating that the password has been changed,<br>Please enter your member ID and changed password on the homepage and log in.</p><p style='font-size:14px;color:#AAAAAA;margin-top:14px;'>After logging in, please change to a new password from the Modify Information menu.</p><p style='font-size:13px;color:#170F00;margin-top:20px;margin-bottom:5px;'>Member ID<span style='font-size:14px;color:#170F00;margin-left:5px;'>{$to}</span></p><p style='font-size:13px;color:#170F00;margin-top:0px;'>Temporary password<span style='font-size:14px;color:#170F00;margin-left:5px;'>{$tmp_password}</span></p><p style='font-size:14px;color:#170F00;margin-top:40px;'>Regards, <br> ISCP</p></div></div>
			<div style='text-align: center;'>
			<a href='{$callback_url}' type='button' style='display: inline-block; width: 300px; height: 35px; line-height: 35px; border-radius: 25px;border: 2px solid #174A77;outline: 2px solid #DFDFDF;background: linear-gradient(to top, #293380, #8CC5D1);font-size: 18px;font-weight: 500;color: #FFFFFF;cursor: pointer; text-decoration: none;'>Change to temporary password</a></div></div><img src='https://iscp2023.org/main/img/mail_footer.png' style='width:100%; margin-top:40px;'>";
		}
	}

	$rawMessage = strtr(base64_encode($rawMessageString), array('+' => '-', '/' => '_'));
	$message->setRaw($rawMessage);
	return $message;
}
/**
 * @param $service Google_Service_Gmail an authorized Gmail API service instance.
 * @param $user string User's email address or "me"
 * @param $message Google_Service_Gmail_Message
 * @return Google_Service_Gmail_Draft
 */
function createDraft($service, $user, $message)
{
	$draft = new Google_Service_Gmail_Draft();
	$draft->setMessage($message);

	try {
		$draft = $service->users_drafts->create($user, $draft);
		//print 'Draft ID: ' . $draft->getId();
	} catch (Exception $e) {
		//print 'An error occurred: ' . $e->getMessage();
	}

	return $draft;
}


/**
 * @param $service Google_Service_Gmail an authorized Gmail API service instance.
 * @param $userId string User's email address or "me"
 * @param $message Google_Service_Gmail_Message
 * @return null|Google_Service_Gmail_Message
 */
function sendMessage($service, $userId, $message)
{
	try {
		$message = $service->users_messages->send($userId, $message);
		// print 'Message with ID: ' . $message->getId() . ' sent.';
		return $message;
	} catch (Exception $e) {
		//print 'An error occurred: ' . $e->getMessage();
	}
	return null;
}


// 대량 메일 발송 테스트 중
if ($_POST["flag"] == "push_mail") {

	try {

		$emails = "'dldnwo200@naver.com', 'ou7970@naver.com', 'ldh@hubdnc.com'";

		$sql =	"SELECT
					idx, email, first_name, last_name
				FROM member
				WHERE email IN ({$emails})
				AND is_deleted = 'N'
				GROUP BY email
				";

		$email_data = get_data($sql);

		$language = "en";

		foreach ($email_data as $ed) {

			$name = "";
			$email = "";

			$name = $ed["last_name"] . " " . $ed["first_name"];
			$email = $ed['email'];

			if (!empty($email) && !empty($name)) {
				$message = createMessage($language, "find_password", $name, $email, "[ISCP] mail_subject", date("Y-m-d H:i:s"), "", "", 0);
				createDraft($service, "secretariat@iscp2023.org", $message);
				sendMessage($service, "secretariat@iscp2023.org", $message);
			}
		}
	} catch (\Throwable $tw) {
		echo $tw->getMessage();
		exit;
	}
}

if ($_POST["flag"] == "find_password") {
	$email = isset($_POST["email"]) ? $_POST["email"] : "";

	$check_user_query =	"SELECT
								idx, email, first_name, last_name, nation_no
							FROM member
							WHERE email = '{$email}'
							AND is_deleted = 'N'";

	$check_user = sql_fetch($check_user_query);

	if (!$check_user) {
		$res = [
			code => 401,
			msg => "does not exist email"
		];
		echo json_encode($res);
		exit;
	}

	$temporary_password = "";
	$random_token = generator_token();		// 비밀번호 찾기시 사용되는 토큰

	for ($i = 0; $i < 6; $i++) {
		$temporary_password .= mt_rand(1, 9);
	}

	//$name = $check_user['nation_no'] == 25 ? $check_user["first_name"].$check_user["last_name"] : $check_user["last_name"]." ".$check_user["first_name"];

	$name = $check_user["last_name"] . " " . $check_user["first_name"];

	$subject = $locale("mail_find_password_subject");
	//$callback_url = "http://54.180.86.106/main/password_reset.php?e=".$email."&t=".$random_token;
	$callback_url = "https://iscp2023.org/main/password_reset.php?e=" . $email . "&t=" . $random_token;
	//$mail_result = mailer($language, "find_password", $name, $email, "[ISCP]" . $subject, date("Y-m-d H:i:s"), $temporary_password, $callback_url, 0);

	$message = createMessage($language, "find_password", $name, $email, "[ISCP]" . $subject, date("Y-m-d H:i:s"), $temporary_password, $callback_url, 0);
	createDraft($service, "secretariat@iscp2023.org", $message);
	sendMessage($service, "secretariat@iscp2023.org", $message);


	$hash_temporary_password = password_hash($temporary_password, PASSWORD_DEFAULT);

	$update_temporary_password_query =	"
											UPDATE member
											SET
												temporary_password = '{$hash_temporary_password}',
												temporary_password_token = '{$random_token}'
											WHERE email = '{$email}'
											AND is_deleted = 'N'
										";

	$update_temporary_password = sql_query($update_temporary_password_query);

	if ($update_temporary_password) {
		$res = [
			code => 200,
			msg => "success"
		];
		echo json_encode($res);
		exit;
	} else {
		$res = [
			code => 400,
			msg => "update query error"
		];
		echo json_encode($res);
		exit;
	}
}

if ($_POST["flag"] == "abstract") {

	try {
		$email = $_POST["email"];
		$name = $_POST["name"];
		$subject = $_POST["subject"];
		$title = $_POST["title"];
		$topic_text = $_POST["topic_text"];
		$time = date("Y-m-d H:i:s");

		$message = createMessage("en", "abstract", $name, $email, $subject, $time, "", "", 1, "", "", "", $email, $time, $topic_text, $title);
		createDraft($service, "secretariat@iscp2023.org", $message);
		sendMessage($service, "secretariat@iscp2023.org", $message);

		$res = [
			code => 200,
			msg => "success"
		];
		echo json_encode($res);
		exit;
	} catch (\Throwable $tw) {
		echo $tw->getMessage();
		exit;
	}
}

if ($_POST["flag"] == "signup_join") {
	$data = isset($_POST["data"]) ? $_POST["data"] : "";
	$name = $data["last_name"] . " " . $data["first_name"];
	$email = $data["email"];
	$time = date("Y-m-d H:i:s");
	$subject = $locale("mail_sign_up_subject");
	$message = createMessage("ko", "signup_join", $name, $email, $subject, $time, "", "", 1, "", "", "", $email, $time, "", "");
	createDraft($service, "secretariat@iscp2023.org", $message);
	sendMessage($service, "secretariat@iscp2023.org", $message);

	if ($message) {
		$res = [
			code => 200,
			msg => "success"

		];
		echo json_encode($res);
		exit;
	} else {
		$res = [
			code => 402,
			msg => "error"
		];
		echo json_encode($res);
		exit;
	}
}


//$message =createMessage("", "dldnwo200@naver.com", "icola2022test", "test6");
//	createDraft($service, "secretariat@icola2022.org", $message);
//	sendMessage($service, "secretariat@icola2022.org", $message);

function generator_token()
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < 10; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
?>