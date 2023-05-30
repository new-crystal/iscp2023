<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/main/plugin/PHPMailer/PHPMailerAutoload.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/main/plugin/PHPMailer/class.phpmailer.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/main/common/locale.php");

class Template
{
	protected $_file;
	protected $_data = array();

	public function __construct($file = null)
	{
		$this->_file = $file;
	}

	public function set($key, $value)
	{
		$this->_data[$key] = $value;
		return $this;
	}

	public function render()
	{
		extract($this->_data);
		ob_start();
		include($this->_file);
		return ob_get_clean();
	}
}

function mailer($language, $mail_type, $fname, $to, $subject, $time, $tmp_password, $callback_url, $type = 0, $file = "", $cc = "", $bcc = "", $id = "", $date = "", $category = "", $title = "")
{ //$language에 따른 content 처리해야됨

	$content = "";

	if ($language == "ko") {
		if ($mail_type == "sign_up") {
			$template = new Template($_SERVER["DOCUMENT_ROOT"] . "/main/common/lib/confirm.php");
			$template->set('callback_url', $callback_url);
			$content = $template->render();
		}

		if ($mail_type == "find_password") {
			//$content =	
			//			"
			//				<div style='width:670px;background-color:#fff;border:1px solid #ADF002;'>
			//					<img src='http://icomes.or.kr/main/img/icomes_mail_top.png' style='width:100%;margin-bottom:60px;'>
			//					<div style='margin-left:60px;margin-bottom:40px;'>
			//						<p style='text-align:left;font-size:15px;color:#170F00;line-height:1.8;'>{$fname} 회원님은<br>{$time} 에 임시 비밀번호 요청을 하셨습니다.</p>
			//						<p style='text-align:left;font-size:12px;color:#AAAAAA;margin-top:22px;'>(만약 임시 비밀번호를 요청하신 적이 없다면 해당 메일을 삭제해 주십시오.)</p>
			//						<p style='text-align:left;font-size:12px;color:#170F00;margin-top:42px;line-height:1.8;'>저희 사이트는 관리자라도 회원님의 비밀번호를 알 수 없기 때문에,<br>
			//						비밀번호를 알려드리는 대신 새로운 비밀번호를 생성하여 안내 해드리고 있습니다.<br>아래에서 변경될 비밀번호를 확인하신 후,</p>
			//						<p style='font-size:13px;color:#FF0000;margin-top:17px;'>임시 비밀번호로 변경 버튼을 클릭하십시오.</p>
			//						<p style='text-align:left;font-size:12px;color:#170F00;margin-top:42px;line-height:1.8;'>비밀번호가 변경되었다는 인증 메시지가 출력되면,<br>
			//						홈페이지에서 회원아이디와 변경된 비밀번호를 입력하시고 로그인 하십시오.</p>
			//						<p style='text-align:left;font-size:12px;color:#AAAAAA;margin-top:17px;'>로그인 후에는 정보수정 메뉴에서 새로운 비밀번호로 변경해 주십시오.</p>
			//						<p style='text-align:left;font-size:13px;color:#170F00;margin-top:32px;'>회원아이디<span style='text-align:left;font-size:14px;color:#170F00;margin-left:5px;'>{$id}</span></p>
			//						<p style='text-align:left;font-size:13px;color:#170F00;margin-top:11px;'>변경될 비밀번호<span style='text-align:left;font-size:14px;color:#170F00;margin-left:5px;'>{$tmp_password}</span></p>
			//						<p style='text-align:left;font-size:14px;color:#170F00;margin-top:51px;'>ICOMES 드림</p>
			//					</div>
			//					<a href='{$callback_url}' style='display:block;text-decoration:none;text-align:center;width:180px;max-width:180px;background:#fff;margin-left:60px;border:1px solid #585859;border-radius:30px;padding:14px 50px;background:#fff;cursor:pointer;color:#000;'>임시 비밀번호로 변경</a>
			//					<img src='http://icomes.or.kr/main/img/icomes_mail_bottom.png' style='width:100%;margin-top:60px;'>
			//				</div>";

			$content = "
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
								<!-- <p style='padding-left:60px;text-align:left;font-size:14px;color:#170F00;margin-top:51px;'>Regards, <br> ICoLA</p> -->
								
								<a href='https://iscp2023.org/main/login.php' style='cursor: pointer;' target='_blank'><img src='https://iscp2023.org/main/img/mail_button.png' style='display:block; margin:0 auto;'></a>
							
							</div>
							<!-- <a href='{$callback_url}' style='display:block;text-decoration:none;text-align:center;width:180px;max-width:180px;background:#fff;margin-left:60px;border:1px solid #585859;border-radius:30px;padding:14px 50px;background:#fff;cursor:pointer;color:#000;'>Change to temporary password</a> -->
							<img src=https://iscp2023.org/main/img/mail_footer.png' style='width:calc(100% + 80px);margin-left:-40px;margin-top:40px;'>
						</div>
						
						";
		}

		if ($mail_type == "abstract") {
			$template = new Template($_SERVER["DOCUMENT_ROOT"] . "/main/common/lib/abstract.php");
			$template->set('id', $id);
			$template->set('date', $date);
			$template->set('category', $category);
			$template->set('title', $title);
			$content = $template->render();
		}
	} else if ($language == "en") {
		if ($mail_type == "sign_up") {
			$template = new Template($_SERVER["DOCUMENT_ROOT"] . "/main/common/lib/confirm.php");
			$template->set('callback_url', $callback_url);
			$content = $template->render();
		}

		if ($mail_type == "find_password") {
			//$content =	
			//			"
			//				<div style='width:670px;background-color:#fff;border:1px solid #ADF002;'>
			//					<img src='http://icomes.or.kr/main/img/icomes_mail_top.png' style='width:100%;margin-bottom:60px;'>
			//					<div style='margin-left:60px;margin-bottom:40px;'>
			//						<p style='text-align:left;font-size:15px;color:#170F00;line-height:1.8;'>Member of {$fname}, <br>You requested a temporary password at {$time}</p>
			//						<p style='text-align:left;font-size:12px;color:#AAAAAA;margin-top:22px;'>(If you have never requested a temporary password, please delete the email.)</p>
			//						<p style='text-align:left;font-size:12px;color:#170F00;margin-top:42px;line-height:1.8;'>Since our site does not have your password even if you are an administrator,<br>
			//						Instead of giving you your password, we're creating a new one and guiding you.<br>Check the password below to change.</p>
			//						<p style='font-size:13px;color:#FF0000;margin-top:17px;'>Click the Change to temporary password button.</p>
			//						<p style='text-align:left;font-size:12px;color:#170F00;margin-top:42px;line-height:1.8;'>When an authentication message is printed stating that the password has been changed,<br>
			//						Please enter your member ID and changed password on the homepage and log in.</p>
			//						<p style='text-align:left;font-size:12px;color:#AAAAAA;margin-top:17px;'>After logging in, please change to a new password from the Modify Information menu.</p>
			//						<p style='text-align:left;font-size:13px;color:#170F00;margin-top:32px;'>Member ID<span style='text-align:left;font-size:14px;color:#170F00;margin-left:5px;'>{$id}</span></p>
			//						<p style='text-align:left;font-size:13px;color:#170F00;margin-top:11px;'>Temporary password<span style='text-align:left;font-size:14px;color:#170F00;margin-left:5px;'>{$tmp_password}</span></p>
			//						<p style='text-align:left;font-size:14px;color:#170F00;margin-top:51px;'>Regards, <br> ICOMES</p>
			//					</div>
			//					<a href='{$callback_url}' style='display:block;text-decoration:none;text-align:center;width:180px;max-width:180px;background:#fff;margin-left:60px;border:1px solid #585859;border-radius:30px;padding:14px 50px;background:#fff;cursor:pointer;color:#000;'>Change to temporary password</a>
			//					<img src='http://icomes.or.kr/main/img/icomes_mail_bottom.png' style='width:100%;margin-top:60px;'>
			//				</div>";

			$content = "<div style='width:670px;background-color:#fff;border:1px solid #000;'><img src='https://iscp2023.org/main/img/mail_header.png' style='width:100%;'><img src='https://iscp2023.org/main/img/mail_header_bom.png' style='width:100%; margin-bottom:60px;'><div style='padding:0 40px'><div style='margin-bottom:25px; background-color:#F8F8F8;border-top:2px solid #707070; padding:17px 34px; box-sizing:border-box;'><div style='margin-bottom:40px;'><p style='font-size:15px; font-weight:bold; color:#000; margin:0;'>member of {$fname}, <br>You requested a temporary password at {$time}</p><p style='font-size:14px;color:#AAAAAA;margin-top:14px;'>(If you have never requested a temporary password, please delete the email.)</p><p style='font-size:14px;color:#170F00;margin-top:30px;'>Since our site does not have your password even if you are an administrator,<br>Instead of giving you your password, we're creating a new one and guiding you.<br>Check the password below to change.</p><p style='font-size:14px;color:#FF0000;margin-top:14px;'>Click the Change to temporary password button.</p><p style='font-size:14px;color:#170F00;margin-top:30px;'>When an authentication message is printed stating that the password has been changed,<br>Please enter your member ID and changed password on the homepage and log in.</p><p style='font-size:14px;color:#AAAAAA;margin-top:14px;'>After logging in, please change to a new password from the Modify Information menu.</p><p style='font-size:13px;color:#170F00;margin-top:20px;margin-bottom:5px;'>Member ID<span style='font-size:14px;color:#170F00;margin-left:5px;'>{$to}</span></p><p style='font-size:13px;color:#170F00;margin-top:0px;'>Temporary password<span style='font-size:14px;color:#170F00;margin-left:5px;'>{$tmp_password}</span></p><p style='font-size:14px;color:#170F00;margin-top:40px;'>Regards, <br> ISCP</p></div></div>
			<div style='text-align: center;'>
			<a href='{$callback_url}' type='button' style='display: inline-block; width: 300px; height: 35px; line-height: 35px; border-radius: 25px;border: 2px solid #174A77;outline: 2px solid #DFDFDF;background: linear-gradient(to top, #293380, #8CC5D1);font-size: 18px;font-weight: 500;color: #FFFFFF;cursor: pointer; text-decoration: none;'>Change to temporary password</a></div></div><img src='https://iscp2023.org/main/img/mail_footer.png' style='width:100%; margin-top:40px;'>";

			//$content = "
			//			<div style='width:670px;background-color:#fff;border:1px solid #000;'>
			//				<img src='https://hubdnc140.cafe24.com/icola/include_mail_2022/mail_header.png' style='width:100%;'>
			//				<img src='https://hubdnc140.cafe24.com/icola/include_mail_2022/mail_header_bom.png' style='width:100%;margin-bottom:60px;'>
			//				<div style='padding:0 40px;'>
			//					<div style='margin-bottom:25px; background-color:#F8F8F8;border-top:2px solid #707070; padding:17px 34px; box-sizing:border-box;'>
			//						<div style='margin-bottom:40px;'>
			//							<p style='font-size:15px; font-weight:bold; color:#000; margin:0;'>Dear {$fname}</p>
			//							<p style='font-size:14px;color:#170F00;margin-top:14px;'>You can log in to the ISCP 2023 website using the ID &<br/>Temporary Password below and modify your password on<br/>Personal Information of MY PAGE.</p>
			//							<table style='border-collapse:collapse; border-top:2px solid #000; width:100%;'>
			//								<tbody>
			//									<tr style='border-bottom:1px solid #000;'>
			//										<th style='width:150px; text-align:left; font-size:14px; padding:10px; background-color:#f1f1f1; '>* ID (E-mail)</th>
			//										<td style='font-size:14px; padding:10px;'>{$to}</td>
			//									</tr>
			//									<tr style='border-bottom:1px solid #000;'>
			//										<th style='width:150px; text-align:left; font-size:14px; padding:10px; background-color:#f1f1f1;'>* Password</th>
			//										<td style='font-size:14px; padding:10px;'>{$tmp_password}</td>
			//									</tr>
			//								</tbody>	
			//							</table>
			//							<p style='font-size:14px;color:#170F00;margin-top:30px;'>If you have not completed online registration or abstract submission,<br/>please go to the ISCP 2023 website and log in<br/>with your ID and password.</p>
			//							<p style='font-size:14px;color:#170F00;margin-top:40px;'>ISCP 2023 Secretariat</p>
			//						</div>
			//					</div>
			//					<!-- <p style='padding-left:60px;text-align:left;font-size:15px;color:#170F00;line-height:1.8;'>Member of mini, <br>You requested a temporary password at 2022-04-07 18:30:08</p> -->
			//					<!-- <p style='padding-left:60px;text-align:left;font-size:12px;color:#AAAAAA;margin-top:22px;'>(If you have never requested a temporary password, please delete the email.)</p> -->
			//					<!-- <p style='padding-left:60px;text-align:left;font-size:12px;color:#170F00;margin-top:42px;line-height:1.8;'>Since our site does not have your password even if you are an administrator,<br> -->
			//					<!-- Instead of giving you your password, we're creating a new one and guiding you.<br>Check the password below to change.</p> -->
			//					<!-- <p style='padding-left:60px;font-size:13px;color:#FF0000;margin-top:17px;'>Click the Change to temporary password button.</p> -->
			//					<!-- <p style='padding-left:60px;text-align:left;font-size:12px;color:#170F00;margin-top:42px;line-height:1.8;'>When an authentication message is printed stating that the password has been changed,<br> -->
			//					<!-- Please enter your member ID and changed password on the homepage and log in.</p> -->
			//					<!-- <p style='padding-left:60px;text-align:left;font-size:12px;color:#AAAAAA;margin-top:17px;'>After logging in, please change to a new password from the Modify Information menu.</p> -->
			//					<!-- <p style='padding-left:60px;text-align:left;font-size:13px;color:#170F00;margin-top:32px;'>Member ID<span style='text-align:left;font-size:14px;color:#170F00;margin-left:5px;'>icomes@naver.com</span></p> -->
			//					<!-- <p style='padding-left:60px;text-align:left;font-size:13px;color:#170F00;margin-top:11px;'>Temporary password<span style='text-align:left;font-size:14px;color:#170F00;margin-left:5px;'>123456789</span></p> -->
			//					<!-- <p style='padding-left:60px;text-align:left;font-size:14px;color:#170F00;margin-top:51px;'>Regards, <br> ICOMES</p> -->
			//					<a href='https://iscp2023.org/main/login.php' style='cursor: pointer;' target='_blank'><img src='https://hubdnc140.cafe24.com/icola/include_mail_2022/mail_button.png' style='display:block; margin:0 auto;'></a>
			//				</div>
			//				<!-- <a href='{$callback_url}' style='display:block;text-decoration:none;text-align:center;width:180px;max-width:180px;background:#fff;margin-left:60px;border:1px solid #585859;border-radius:30px;padding:14px 50px;background:#fff;cursor:pointer;color:#000;'>Change to temporary password</a> -->
			//				<img src='https://hubdnc140.cafe24.com/icola/include_mail_2022/mail_footer.png' style='width:100%;margin-top:40px;'>
			//			</div>
			//	";
		}

		if ($mail_type == "abstract") {
			//$template = new Template($_SERVER["DOCUMENT_ROOT"]."/main/common/lib/abstract.php");
			//$template->set('id', $id);
			//$template->set('date', $date);
			//$template->set('category', $category);
			//$template->set('title', $title);
			//$content = $template->render(); 

			$content = "
						<div style='width:670px;background-color:#fff;border:1px solid #000; padding:0 40px;'>
							<img src=https://iscp2023.org/main/img/mail_header.png' style='width:calc(100% + 80px);margin-left:-40px;'>
							<!-- <img src='https://iscp2023.org/main/img/mail_header_bom.png' style='width:calc(100% + 80px);margin-left:-40px;margin-bottom:60px;'> -->
							<div style='width:calc(100% + 80px);margin-left:-40px;margin-bottom:60px;background-color:#00666B;text-align:center;font-size: 21px; color: #FFF;padding: 10px 0;'>[ISCP 2023 with APSAVD] Abstract Successfully Submitted</div>	
							<div>
								<div style='margin-bottom:25px; background-color:#F8F8F8;border-top:2px solid #707070; padding:17px 34px; box-sizing:border-box;'>
									<div style='margin-bottom:40px;'>
										<p style='font-size:15px; font-weight:bold; color:#000; margin:0;'>Dear {$fname}</p>
										<p style='font-size:14px;color:#170F00;margin-top:14px;'>
											Attention Potential Presenting Author: Upon successful submission of your abstract, you will immediately see the following confirmation notice on your screen, followed by the same message via e&#45;mail. If you did not receive the following message, your abstract was not successfully submitted. Please try again, or contact (secretariat@icola2022.org) for assistance if you are having difficulty. 
											<br>
											The deadline for abstract submissions is 20 June (submissions close at 11:59pm Korea Standard Time). It is your responsibility to address questions about submissions before 20 June, so that if there is a problem, we can still help you make the submission on time. Be sure to print and/or save the confirmation of submission notices for reference in case of a problem or question.
										</p>

										<p style='font-size:15px; font-weight:bold; color:#000; margin-top:30px;'>Abstract Successfully Submitted</p>
										<p style='font-size:14px; color:#170F00; margin-top:14px;'>This is an automated message. Please do not reply</p>
										<ul style='list-style:none; padding-left:10px;'>
											<li style='font-size:14px; font-weight:bold; color:#000'>ID : <span style='font-size:14px; font-weight:400; color:#000;'>[{$to}]</span></li>
											<li style='font-size:14px; font-weight:bold; color:#000'>Submission date : <span style='font-size:14px; font-weight:400; color:#000;'>{$date}</span></li>
											<li style='font-size:14px; font-weight:bold; color:#000'>Topic : <span style='font-size:14px; font-weight:400; color:#000;'>{$category}</span></li>
											<li style='font-size:14px; font-weight:bold; color:#000'>Abstract title : <span style='font-size:14px; font-weight:400; color:#000;'>{$title}</span></li>
										</ul>
										<p style='font-size:14px;color:#170F00;margin-top:14px;'>If you have any questions regarding call for abstracts, please contact the secretariat (<a href='mailto:secretariat@icola2022.org)'>secretariat@icola2022.org</a>)</p>
										<p style='font-size:14px;color:#170F00;margin-top:14px;'>We look forward to seeing you in ISCP 2023.</p>
										<p style='font-size:14px;color:#170F00;margin-top:14px;'>Warmest regards,</p>
										<p style='font-size:14px;color:#170F00;margin-top:14px;'>ISCP 2023 Secretariat. </p>
									</div>
								</div>
								<div style='text-align: center;'>
									<a href='https://iscp2023.org/main/login.php' type='button' style='display: inline-block; width: 300px; height: 35px; line-height: 35px; border-radius: 25px;border: 2px solid #174A77;outline: 2px solid #DFDFDF;background: linear-gradient(to top, #293380, #8CC5D1);font-size: 18px;font-weight: 500;color: #FFFFFF;cursor: pointer; text-decoration: none;'>Go to <b>ISCP 2023</b> Website</a>
								</div>
							</div>
							<img src='https://iscp2023.org/main/img/mail_footer.png' style='width:calc(100% + 80px);margin-left:-40px;margin-top:40px;'>
						</div>
						";
		}
	}
	//$content = htmlspecialchars($content);

	if ($type != 1) {
		$content = nl2br($content);
	}

	$mail = new PHPMailer(); // defaults to using php "mail()"

	/*$mail->ContentType = "text/html";
    $mail->CharSet = "utf-8";

	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "smtp.naver.com"; //네이버 맞는지?
	$mail->Port = 465;
	$mail->Username = ""; // admin@domain.com //ICOMES 측 이메일 확인받아야함 info@icomes.or.kr
	$mail->Password = "";// 비밀번호 into2285
	//$mail->SMTPDebug = 3;

	$mail->From = ""; //보낸 사람 이메일
	$mail->FromName = "ICOLA2022"; //보낸 사람 이름
	$mail->Subject = $subject;
    $mail->AltBody = ""; // optional, comment out and test
    $mail->IsHTML(true);
    //$mail->Body = $content;//허브디앤씨 작성 -> mail body가 plane text 인 경우
    $mail->MsgHTML($content);//인투온 작성 -> mail body가 html인 경우*/

	// $account['username'] = "secretariat@icola2022.org";
	// $account['password'] = "icola2022!!";
	$account['username'] = "secretariat@iscp2023.org";
	$account['password'] = "iscp2023!!";

	$mail->CharSet = "UTF-8";
	$mail->Encoding = "base64";

	$mail->IsSMTP();
	//$mail->SMTPDebug = 1;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "smtp.gmail.com"; //네이버 맞는지?
	$mail->Port = 465;
	$mail->IsHTML(true);
	$mail->Username = $account['username']; // admin@domain.com //ICOMES 측 이메일 확인받아야함 info@icomes.or.kr
	$mail->Password = $account['password']; // 비밀번호 into2285
	//$mail->SMTPDebug = 3;

	//$mail->CharSet = 'UTF-8';
	$mail->From = $account['username']; //보낸 사람 이메일
	$mail->FromName = "ISCP2023"; //보낸 사람 이름
	$mail->Subject = $subject;
	$mail->AltBody = ""; // optional, comment out and test
	$mail->MsgHTML($content);

	$mail->addAddress($to);
	if ($cc)
		$mail->addCC($cc);
	if ($bcc)
		$mail->addBCC($bcc);
	//print_r2($file); exit;
	if ($file != "") {
		foreach ($file as $f) {
			$mail->addAttachment($f['path'], $f['name']);
		}
	}
	try {
		return $mail->send();
	} catch (\Throwable $tw) {
		echo $tw->getMessage();
		exit;
	}
}

// 파일을 첨부함
function attach_file($filename, $tmp_name)
{
	// 서버에 업로드 되는 파일은 확장자를 주지 않는다. (보안 취약점)
	$dest_file = D9_DATA_PATH . '/tmp/' . str_replace('/', '_', $tmp_name);
	move_uploaded_file($tmp_name, $dest_file);
	$tmpfile = array("name" => $filename, "path" => $dest_file);
	return $tmpfile;
}
