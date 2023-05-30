var ko = {
	hello : '안녕하세요.',
	welcome : '환영합니다.',

	//등록
	check_attendance_type : "온라인/오프라인을 선택해주세요.",
	check_review : "평점신청여부를 선택해주세요.",
	check_registration_type : "참석 유형을 선택해주세요.",
	complet_registration : "등록 신청이 완료되었습니다.",
	error_registration : "등록 신청에 실패하였습니다.",
	already_registration : "이미 등록하셨습니다.",
	payment_fail_msg : "결제에 실패하였습니다.",
	check_applied_org : "평점신청협회를 선택해주세요.",
	check_identification_file : "증빙서류를 등록해주세요.",

	//회원가입
	used_email_msg : "이미 사용 중인 이메일입니다.",
	mismatch_password : "비밀번호가 일치하지 않습니다.",
	complet_signup : "회원가입이 완료되었습니다.\n이메일 인증 후 로그인이 가능합니다.",
	signup_mail_send : "이메일 인증 메일을 발송했습니다.\n이메일 인증 후 로그인이 가능합니다.",
	error_signup : "회원가입에 실패하셨습니다.",
	check_terms1 : "이용약관에 동의하지 않으셨습니다.",
	check_terms2 : "개인정보이용약관에 동의하지 않으셨습니다.",

	//로그인
	not_matching_email : "입력하신 ID(이메일)을 확인해주세요.",
	not_matching_password : "입력하신 비밀번호를 확인해주세요.",
	not_certified_email : "계정 인증이 완료되지 않았습니다. 인증 후 로그인 해주세요.",

	//비밀번호 찾기
	error_find_password : "비밀번호 찾기에 실패하였습니다.",
	not_exist_email : "입력하신 아이디(이메일)를 확인해주세요.",
	send_mail_success : "입력하신 이메일로 메일이 전송되었습니다.",

	//마이페이지 > 계정
	account_modify_msg : "계정 정보를 수정하시겠습니까?",
	complet_account_modify : "계정 정보 수정이 완료되었습니다.",
	error_account_modify : "계정 정보 수정이 실패하였습니다.",

	//마이페이지 > 등록
	registration_modify_msg : "등록 정보를 수정하시겠습니까?",
	complet_registration_modify : "등록 정보가 수정되었습니다.",
	error_registration_modify : "등록 정보 수정에 실패하였습니다.",
	registration_cancel_msg : "사전등록 취소 후 철회가 불가능합니다. 정말 취소하시겠습니까?",
	complet_registration_cancel : "사전등록 취소가 완료되었습니다.",
	error_registration_cancel : "사전등록 취소에 실패하였습니다.",
	registration_refund_msg : "해당 건에 대해 환불요청 하시겠습니까?",
	complet_registration_refund : "환불요청 신청이 등록되었습니다.",
	error_registration_refund : "환불요청 신청이 거절되었습니다.",
	invalid_registration_status : "사전등록의 정보가 유효하지 않습니다. 관리자에게 문의해주세요.",

	//마이페이지 > 초록
	submission_cancel_msg : "제출하신 초록을 삭제하시겠습니까?",
	complet_submission_cancel : "초록 삭제가 완료되었습니다.",
	error_submission_cancel : "초록 삭제에 실패하였습니다.",

	//논문/강연노트 제출
	complet_submission : "제출이 완료되었습니다.",
	check_registration : "사전등록하신 회원만 제출하실 수 있습니다.",
	already_submission : "이미 제출하셨습니다.",
	file_size_error : "5GB 이하의 파일만 첨부할 수 있습니다.",

	//논문/강연노트 제출 > 공동저자
	check_co_nation : "공동저자 국가를 선택해주세요.",
	check_co_city : "공동저자 도시를 입력해주세요.",
	check_co_first_name : "공동저자의 이름을 입력해주세요.",
	check_co_last_name : "공동저자의 이름(성)을 입력해주세요.",
	check_co_affiliation : "공동저자의 소속을 입력해주세요.",
	check_co_email : "공동저자의 이메일을 입력해주세요.",
	check_co_phone : "공동저자의 핸드폰 번호를 입력해주세요.",
	check_co_position : "공동저자의 구분을 선택해주세요.",

	//논문/강연노트 제출 > 논문
	check_abstract_title : "논문 제목을 입력해주세요.",
	check_abstract_category : "논문 카테고리를 선택해주세요.",
	check_abstract_position : "논문 구분을 선택해주세요.",
	check_abstract_text : "논문 설명을 입력해주세요.",
	check_abstract_file : "논문 파일을 첨부해주세요.",
	check_oral_presentation : "연설여부를 선택해주세요.",
	check_abstract_thumnail : "논문 썸네일을 선택해주세요.",
	abstract_submit_ok : "논문 제출이 완료되었습니다.",
	abstract_submit_error : "논문 제출에 실패하였습니다.",
	under_25 : "논문 제목은 25자 이하로 작성해주세요.",
	under_300 : "논문 설명은 300자 이하로 작성해주세요.",

	//논문/강연노트 제출 > 강연노트
	check_presentation_type : "Presentation type을 선택해주세요.",
	check_cv : "약력을 입력해주세요.",
	check_lecture_file : "강연노트 파일을 첨부해주세요",
	lecture_submit_error : "강연노트 제출에 실패하였습니다.",

	//후원 > 후원등록
	check_sponsorship_package : "후원 패키지를 선택해주세요.",
	check_manager_first_name : "담당자 이름을 입력해주세요.",
	check_manager_last_name : "담당자 이름(성)을 입력해주세요.",
	check_business_licence_file : "사업자등록증 파일을 첨부해주세요.",
	check_signature_file : "온라인 서명 파일을 첨부해주세요.",
	complet_application : "후원 신청이 완료되었습니다.",
	error_application : "후원 신청에 실패하였습니다.",
	mismatch_file_type : "올바르지 않은 파일 형식입니다.",

	//공통
	confirm_msg : "입력하신 정보들로 제출하시겠습니까?",
	reject_msg : "일시적으로 요청이 거절되었습니다.",
	language_success_msg : "언어 변환 성공",
	retry_msg : "다시 시도해주세요.",
	need_login : "로그인이 필요합니다.",
	invalid_auth : "접근 권한이 없습니다.",
	
	//유효성
	format_email : "올바르지 않은 이메일 형식입니다.",
	check_nation : "국가를 선택해주세요.",
	check_email : "이메일을 입력해주세요.",
	check_password : "비밀번호를 입력해주세요.",
	check_first_name : "이름을 입력해주세요.",
	check_last_name : "이름(성)을 입력해주세요.",
	check_phone : "핸드폰 번호를 입력해주세요.",
	check_city : "도시를 입력해주세요.",
	check_affiliation : "소속을 입력해주세요.",
	check_member_type : "참가자 유형을 선택해주세요.",
	check_member_status : "회원 여부를 선택해주세요.",
	check_register_path : "가입 경로를 선택해주세요.",
	check_company_name : "회사명을 입력해주세요.",
	check_ceo : "대표자/CEO을 입력해주세요.",
	check_address : "주소를 입력해주세요.",
	check_website : "공식 사이트를 입력해주세요.",
	check_position : "직책을 입력해주세요.",
	check_mobile : "휴대폰번호를 입력해주세요.",
	check_presentation_type : "발표타입을 선택해주세요.",
	check_abstract_category : "카테고리를 선택해주세요.",
	check_abstract_position : "구분을 선택해주세요.",

	over_6 : "을(를) 6자 이상 입력해주세요.",
	under_50 : "을(를) 50자 이하로 입력해주세요.",
	under_100 : "을(를) 100자 이하로 입력해주세요.",
	under_20 : "을(를) 20자 이하로 입력해주세요.",

	leave_page : "현재 페이지에서 나가시겠습니까?"
}