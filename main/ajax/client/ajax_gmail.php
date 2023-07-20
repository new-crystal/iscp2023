
<?php include_once("../../common/common.php"); ?>
<?php include_once("../../common/locale.php"); ?>

<?php
include_once('../../../../icomes.or.kr/main/plugin/google-api-php-client-main/vendor/autoload.php');



$language = isset($_SESSION["language"]) ? $_SESSION["language"] : "en";
$locale = locale($language);

if (php_sapi_name() != 'cli') {
	//throw new Exception('This application must be run on the command line.');
}

$input_post = json_decode(file_get_contents("php://input"), true);
$_POST = empty($_POST) ? $input_post : $_POST;

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

function createMessage($language, $mail_type, $fname, $to, $subject, $time, $tmp_password, $callback_url, $type = 0, $file = "", $cc = "", $bcc = "", $id = "", $date = "", $category = "", $title = "", array $data = [])
{
	$message = new Google_Service_Gmail_Message();

	$rawMessageString = "From: ISCP2023<secretariat@iscp2023.org>\r\n";
	$rawMessageString .= "To: <{$to}>\r\n";
	$rawMessageString .= 'Subject: =?utf-8?B?' . base64_encode($subject) . "?=\r\n";
	$rawMessageString .= "MIME-Version: 1.0\r\n";
	$rawMessageString .= "Content-Type: text/html; charset=utf-8\r\n";
	$rawMessageString .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";

	if ($mail_type == "signup_join") {

		$rawMessageString .= "
		<table width='750' style='border:1px solid #000; padding: 0;'>
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
						<div style='text-align: center; width:250px;'>
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
	} else if ($mail_type == "payment") {
		$data = isset($_POST["data"]) ? $_POST["data"] : "";

		$name_title = $data["name_title"] ?? "";

		$register_no = $data["idx"] ? "ICOMES2023-" . $data["idx"] : "-";
		$register_date = $data["register_date"] ?? "-";

		$licence_number = $data["licence_number"] ? $data["licence_number"] : "Not applicable";
		$specialty_number = $data["specialty_number"] ? $data["specialty_number"] : "Not applicable";
		$nutritionist_number = $data["nutritionist_number"] ? $data["nutritionist_number"] : "Not applicable";

		$attendance_type = $data["attendance_type"] ?? "-";
		$attendance_type = $data["registration_type"] ?? "-";
		switch ($attendance_type) {
			case 0:
				$attendance_type = "General Participants";
				break;
			case 2:
				$attendance_type = "Committee";
				break;
			case 1:
				$attendance_type = "Invited Speaker";
				break;
		}

		$is_score = $data["is_score"] ?? "";
		$is_score = ($is_score == 1) ? "필요" : "불필요";

		$member_status = $data["member_status"] ?? "-";
		$member_status = ($member_status == 1) ? "Yes" : "No";

		$nation_no = $data["nation_no"] ?? "";
		$nation_sql = "SELECT
							idx, nation_en, nation_tel
						FROM nation
						WHERE idx = {$nation_no}";

		$nation = sql_fetch($nation_sql);
		$nation_tel = $nation["nation_tel"] ?? "";
		$nation_en = $nation["nation_en"] ?? "-";

		$phone = $data["phone"] ?? "";
		$member_type = $data["member_type"] ?? "";
		$registration_type = $data["registration_type"] ?? "-";
		$registration_type = ($registration_type == 0) ? "Yes" : "No";

		$affiliation = $data["affiliation"] ?? "-";
		$department = $data["department"] ?? "-";
		$academy_number = $data["academy_number"] ?? "-";

		// Others
		$welcome_reception_yn = $data["welcome_reception_yn"] ?? "N";
		$day2_breakfast_yn = $data["day2_breakfast_yn"] ?? "N";
		$day2_luncheon_yn = $data["day2_luncheon_yn"] ?? "N";
		$day3_breakfast_yn = $data["day3_breakfast_yn"] ?? "N";
		$day3_luncheon_yn = $data["day3_luncheon_yn"] ?? "N";

		$other_html = "";

		if ($welcome_reception_yn == "Y") {
			$other_html .= "
							<input type='checkbox' class='checkbox' id='other1'>
							<label for='other1'><i></i>Welcome Reception – September 7(Thu)</label>
						   ";
		}
		if ($day2_breakfast_yn == "Y") {
			$other_html .= $other_html != "" ? "<br/>" : "";
			$other_html .= "
							<input type='checkbox' class='checkbox' id='other2'>
							<label for='other2'><i></i>Day 2 Breakfast Symposium – September 8(Fri)</label>
						   ";
		}
		if ($day2_luncheon_yn == "Y") {
			$other_html .= $other_html != "" ? "<br/>" : "";
			$other_html .= "
							<input type='checkbox' class='checkbox' id='other3'>
							<label for='other3'><i></i>Day 2 Luncheon Symposium – September 8(Fri)</label>
						   ";
		}
		if ($day3_breakfast_yn == "Y") {
			$other_html .= $other_html != "" ? "<br/>" : "";
			$other_html .= "
							<input type='checkbox' class='checkbox' id='other4'>
							<label for='other4'><i></i>Day 3 Breakfast Symposium – September 9(Sat)</label>
						   ";
		}
		if ($day3_luncheon_yn == "Y") {
			$other_html .= $other_html != "" ? "<br/>" : "";
			$other_html .= "
							<input type='checkbox' class='checkbox' id='other5'>
							<label for='other5'><i></i>Day 3 Luncheon Symposium – September 9(Sat)</label>
						   ";
		}

		if ($other_html == "") $other_html = "-";

		// Conference Info
		$info_html = "";
		$info = explode("*", $data["conference_info"] ?? "");

		for ($a = 0; $a < count($info); $a++) {
			if ($info[$a]) {
				$info_html .= $info_html != "" ? "<br/>" : "";
				$info_html .= "
								<input type='checkbox' class='checkbox' id='conference" . $a . "'>
								<label for='conference" . $a . "'><i></i>" . $info[$a] . "</label>
							  ";
			}
		}

		if ($info_html == "") $info_html = "-";

		// Price
		$pay_type = $data["pay_type"] ?? "";
		$pay_name = "-";

		if ($pay_type == "card") $pay_name = "Credit Card";
		else if ($pay_type == "bank") $pay_name = "Bank Transfer";
		else if ($pay_type == "free") $pay_name = "Free";
		else $pay_name = "ETC";

		$pay_date = $data["payment_date"] ?? "-";

		$pay_price = $data["price"] ? number_format($data["price"]) : "-";
		$pay_current = $nation_tel == "82" ? "KRW" : "USD";


		if ($pay_type == "card" || $pay_type == "free") {
			$pay_html = "
							<tr style='border-bottom:1px solid #000;'>
								<th style='width:150px; text-align:left; font-size:14px; padding:10px; background-color:#DBF5F0; '>Payment Status</th>
								<td style='font-size:14px; padding:10px; color:#00666B; font-weight:bold' >Complete</td>
							</tr>
							<tr style='border-bottom:1px solid #000;'>
								<th style='width:150px; text-align:left; font-size:14px; padding:10px; background-color:#DBF5F0; '>Payment Date</th>
								<td style='font-size:14px; padding:10px;'>{$pay_date}</td>
							</tr>
						";
		}
		// else {
		// 	$pay_html = "
		// 					<tr style='border-bottom:1px solid #000;'>
		// 						<th style='width:150px; text-align:left; font-size:14px; padding:10px; background-color:#DBF5F0; '>Payment Status</th>
		// 						<td style='font-size:14px; padding:10px; color:#00666B; font-weight:bold'>Needed</td>
		// 					</tr>
		// 					<tr style='border-bottom:1px solid #000;'>
		// 						<th style='width:150px; text-align:left; font-size:14px; padding:10px; background-color:#DBF5F0; '>Bank Information</th>
		// 						<td style='font-size:14px; padding:10px;'>584-910003-16504, Hana Bank (하나은행)</td>
		// 					</tr> 
		// 				";
		// }

		$rawMessageString .= "  <table width='750' style='border:1px solid #000; padding: 0;'>
        <tbody>
            <tr>
                <td colspan='3'>
                    <img src='https://iscp2023.org/main/img/mail_header.png' width='750' style='width:100%; max-width:100%;'>
                </td>
            </tr>
            <tr>
                <td width='74' style='width:74px;'></td>
                <td>
                    <div style='font-weight:bold; text-align:center; font-size: 21px; color: #00666B; padding: 20px 0;'>[ISCP 2023] Completed Registration</div>
                </td>
                <td width='74' style='width:74px;'></td>
            </tr>
            <tr>
                <td width='74' style='width:74px;'></td>
                <td>
                    <div>
                        <p style='font-size:15px; font-weight:bold; color:#000; margin:0;'>Dear {$name_title} {$fname},</p>
                        <p style='font-size:14px;color:#170F00;margin-top:14px;'>We express our gratitude for your registration for the  International Society
                            of Cardiovascular Pharmacotherapy (ISCP) 2023. The registration details are presented below.
                            Should you have any inquiries regarding your registration, kindly reach out to the ISCP 2023 Secretariat for assistance.(iscp@into-on.com) </a>)</p>
                        <table width='586' style='width:586px; border-collapse:collapse; border-top:2px solid #000; width:100%; margin:17px 0;'>
                            <tbody>
                               
                                <tr style='border-bottom:1px solid #000;'>
                                    <th style='width:150px; text-align:left; font-size:14px; padding:10px;'>Name</th>
                                    <td style='font-size:14px; padding:10px;border-left:1px solid #000; width:165px;'>{$fname}</td>
                                </tr>
                                
                                <tr style='border-bottom:1px solid #000;'>
                                    
                                <tr style='border-bottom:1px solid #000;'>
                                    <th style='width:150px; text-align:left; font-size:14px; padding:10px;'>Type of Participation</th>
                                    <td style='font-size:14px; padding:10px;border-left:1px solid #000;'>{$attendance_type}</td>
                                </tr>
                             
                                <tr style='border-bottom:1px solid #000;'>
                                    <th style='width:150px; text-align:left; font-size:14px; padding:10px; background-color:#DBF5F0; '>Payment Method</th>
                                    <td style='font-size:14px; padding:10px;'>{$pay_name}</td>
                                </tr>
                                {$pay_html}
                               
                            </tbody>	
                        </table>
                        <p>We eagerly anticipate your presence in Seoul, Korea this coming November.</p>
                    </div>
                </td>
                <td width='74' style='width:74px;'></td>
            </tr>
            <tr>
                <td width='74' style='width:74px;'></td>
                <td>
                    <p>Warmest regards,</p>
                    <p>Secretariat of ISCP 2023</p>
                    <br/>
                    <div style='text-align: center;'>
                        <a href='https://iscp2023.org/main/login.php' style='cursor: pointer;' target='_blank'><img src='https://iscp2023.org/main/img/mail_button.png' style='display:block; margin:0 auto;  width:250px;'></a>
                    </div>
                </td>
                <td width='74' style='width:74px;'></td>
            </tr>
            <tr>
                <td colspan='3' style='padding-top:50px;'>
                    <img src='https://iscp2023.org/main/img/mail_footer.png' width='750' style='width:100%; max-width:100%;'>
                </td>
            </tr>
        </tbody>
    </table>";
	} else if ($mail_type == "abstract") {
		$rawMessageString .= "
					<div style='width:670px;background-color:#fff;border:1px solid #000; font-size:0;'>
						<img src='https://iscp2023.org/main/img/mail_header.png' style='width:100%; margin:0;'>
						<div style='width:100%;margin:0 0 60px 0;background-color:#00666B;text-align:center;font-size: 21px; color: #FFF;padding: 10px 0;'>[ISCP 2023] Abstract Successfully Submitted</div>	
						<div style='padding:0 40px;'>
							<div style='margin-bottom:25px; background-color:#F8F8F8;border-top:2px solid #707070; padding:17px 34px; box-sizing:border-box;'>
								<div style='margin-bottom:40px;'>
									<p style='font-size:15px; font-weight:bold; color:#000; margin:0;'>Dear {$fname}</p>
									<p style='font-size:14px;color:#170F00;margin-top:14px;'>
									Attention Potential Presenting Author: Upon successful submission of your abstract, you will immediately see the following confirmation notice on your screen, followed by the same message via e-mail. If you did not receive the following message, your abstract was not successfully submitted. Please try again, or contact (iscp@into-on.com) for assistance if you are having difficulty.
										<br>
										The deadline for abstract submissions is  October 27 (Fri) (submissions close at 11:59pm Korea Standard Time). It is your responsibility to address questions about submissions before  October 27 (Fri), so that if there is a problem, we can still help you make the submission on time. Be sure to print and/or save the confirmation of submission notices for reference in case of a problem or question.
										<br>
										Please note: You can modify the submitted abstract until the deadline.
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
	} else if ($mail_type == "find_password") {
		$rawMessageString .= "<table width='750' style='border:1px solid #000; padding: 0;'>
		<tbody>
			<tr>
				<td colspan='3'>
					<img src='https://iscp2023.org/main/img/mail_header.png' width='750' style='width:100%; max-width:100%;'><img src='https://iscp2023.org/main/img/mail_header_bom.png' width='750' style='width:100%; max-width:100%;'>
				</td>
			</tr>
			<tr>
				<td colspan='3'>
					<div style='font-weight:bold; text-align:center;font-size: 21px; color: #00666B;padding: 20px 0;'>[ISCP 2023] Temporary Password</div>
				</td>
			</tr>
			<tr>
				<td width='74' style='width:74px;'></td>
				<td>
					<div>
						<div style='margin-bottom:20px'>
							<p style='font-size:15px; font-weight:bold; color:#000; margin:0;'>Member of : {$fname}<br><span style='font-size:14px;color:#170F00;font-weight:normal;'>You requested a temporary password at : {$time}</span></p>
						</div>
						<p style='font-size:15px; font-weight:bold; color:#000; margin:0;'>Dear {$fname},</p>
						<p style='font-size:14px;color:#170F00;margin-top:14px;'>You can log in to the ISCP 2023 website using the ID & Temporary Password below and modify your password on the personal information on my page.</p>
						<table width='586' style='width:586px; border-collapse:collapse; border-top:2px solid #000; width:100%; margin:17px 0;'>
							<tbody>
								<tr>
									<th style='width:150px; text-align:left; font-size:14px; padding:10px; border-bottom:1px solid #000;'>ID(Email Address)</th>
									<td style='font-size:14px; padding:10px; border-left:1px solid #000; border-bottom:1px solid #000;'><a href='mailto:{$to}' class='link font_inherit'>{$to}</a></td>
								</tr>
								<tr>
									<th style='width:150px; text-align:left; font-size:14px; padding:10px; border-bottom:1px solid #000;'>Temporary Password</th>
									<td style='font-size:14px; padding:10px; border-left:1px solid #000; border-bottom:1px solid #000;'>{$tmp_password}</td>
								</tr>
							</tbody>	
						</table>
						<p style='color:#f00;'>Click the 'Change to temporary password' button to check your changed log-in information.</p>
					</div>
				</td>
				<td width='74' style='width:74px;'></td>
			</tr>
			<tr>
				<td width='74' style='width:74px;'></td>
				<td>
					<div style='text-align: center;'>
						<a href='https://iscp2023.org/main/login.php'><img src='https://iscp2023.org/main/img/mail_button.png' alt='' style='width:250px'></a>
					</div>
					<p>Best regards,ISCP</p>
				</td>
				<td width='74' style='width:74px;'></td>
			</tr>
			<tr>
				<td colspan='3' style='padding-top:50px;'>
					<img src='https://iscp2023.org/main/img/mail_footer.png' width='750' style='width:100%; max-width:100%;'>
				</td>
			</tr>
		</tbody>
	</table>";
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
				$message = createMessage($language, "find_password", $name, $email, "[ISCP 2023] mail_subject", date("Y-m-d H:i:s"), "", "", 0);
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

	$message = createMessage($language, "find_password", $name, $email, "[ISCP 2023]" . $subject, date("Y-m-d H:i:s"), $temporary_password, $callback_url, 0);
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
	echo '<script>';
	echo 'console.log("hello")';
	echo '</script>';
	$data = isset($_POST["data"]) ? $_POST["data"] : "";
	$name = $data["last_name"] . " " . $data["first_name"];
	$email = $data["email"];
	$time = date("Y-m-d H:i:s");
	$subject = $locale("mail_sign_up_subject");
	$message = createMessage("en", "signup_join", $name, $email, $subject, $time, "", "", 1, "", "", "", $email, $time, "", "", "");
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

if ($_POST["flag"] == "payment_mail") {

	$name = $_POST["name"] ?? null;
	$email = $_POST["email"] ?? null;
	$data = $_POST["data"] ?? null;
	$message = createMessage("en", "payment", $name, $email, "[ISCP2023] Payment Confirmation", date("Y-m-d H:i:s"), "", "", 1, "", "", "", "", "", "", "", $data);
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