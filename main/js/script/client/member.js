var checkType = $("input[name=check_type]").val() ? $("input[name=check_type]").val() : 0;

//pc
$(document).ready(function(){

	//생일 날짜 미래 막기
	var today = new Date();   
	var year = today.getFullYear(); // 년도
	var month = today.getMonth() + 1;  // 월
	var date = today.getDate();  // 날짜
	var day = today.getDay();  // 요일

	var now_today = year+"-"+month+"-"+(date);
	//document.write(year + '/' + month + '/' + date);

	$("#datepicker").datepicker({
		dateFormat: 'dd-mm-yyyy',
		minDate: new Date('1900-01-01'),
		maxDate: new Date(now_today)
	});

	$("#mb_datepicker").datepicker({
		dateFormat: 'dd-mm-yyyy',
		minDate: new Date('1900-01-01'),
		maxDate: new Date(now_today)
	});

	//이메일 중복 검증
	$("input[name=email]").on("change", function(){
		var email = $(this).val();
		var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
		
		if(email.match(regExp) != null) {
			$.ajax({
				url : PATH+"ajax/client/ajax_member.php", 
				type : "POST", 
				data :  {
					flag : "id_check",
					email : email
				},
				dataType : "JSON", 
				success : function(res){
					if(res.code == 200) {
						//$(".red_alert").eq(0).html("good");
						//$(".red_alert").eq(0).css('display', 'none');
					} else if(res.code == 400) {
						alert(locale(language.value)("used_email_msg"));
						//$(".red_alert").eq(0).html("used_email_msg");
						$("input[name=email]").val("").focus();
						//$(".red_alert").eq(0).css('display', 'block');
						return;
					} else {
						//alert(locale(language.value)("reject_msg"))
						//$(".red_alert").eq(0).html("reject_msg");
						//$(".red_alert").eq(0).css('display', 'block');
						return;
					}
				}
			});
		} else {
			alert(locale(language.value)("format_email"));
			//$(".red_alert").eq(0).html("format_email");
			//$(".red_alert").eq(0).css('display', 'block');
			$(this).val("").focus();
			return;
		}
	});

	$(".passwords").on("keyup", function(){
		$(this).val($(this).val().replace(/[\s]/g,""));
	});

	$(".email_id").on("keyup", function(key){
		var pattern_eng = /[^a-zA-Z||\0-9||@]/gi;
		var _this = $(this);
		if(key.keyCode != 8) {
			var first_name = _this.val().replace(pattern_eng, '');
			_this.val(first_name);
		}

		//name_check("affiliation", 6);
	});

	////비밀번호 유효성
	//$("input[name=password]").on("change keyup", function(){
	//	pw_check(1);
	//});
	//$("input[name=password2]").on("change keyup", function(){
	//	pw_check(2);
	//});

	//function pw_check(i) {
	//	var pw1 = $("input[name=password]").val();
	//	var pw1_len = pw1.trim().length;
	//	pw1 = (typeof(pw1) != "undefined") ? pw1 : null;
	//	
	//	var pw2 = $("input[name=password2]").val();
	//	var pw2_len = pw2.trim().length;
	//	pw2 = (typeof(pw2) != "undefined") ? pw2 : null;
	

	//	if(i==1) {
	//		if(!pw1 || pw1_len <= 0) {
	//			$("input[name=password]").focus();
	//			$(".red_alert").eq(1).html("format_passwrod");
	//			$(".red_alert").eq(1).css('display', 'block');
	//		} else {
	//			$(".red_alert").eq(1).html("good");
	//			$(".red_alert").eq(1).css('display', 'none');
	//		}
	//	} else {
	//		if(!pw2 || pw2_len <= 0) {
	//			$("input[name=password2]").focus();
	//			$(".red_alert").eq(2).html("format_passwrod");
	//			$(".red_alert").eq(2).css('display', 'block');
	//		} else {
	//			$(".red_alert").eq(2).css('display', 'none');
	//		}
	//	}
	//	
	//	if(pw1_len > 0 && pw2_len > 0) {
	//		if(pw1 !== pw2) {
	//			$(".red_alert").eq(2).html("inconsistency_passwrod");
	//			$(".red_alert").eq(2).css('display', 'block');
	//		}
	//		else {
	//			$(".red_alert").eq(2).html("good");
	//			$(".red_alert").eq(2).css('display', 'none');
	//			$(".red_alert").eq(1).html("good");
	//			$(".red_alert").eq(1).css('display', 'none');
	//		}
	//	}
	//}

	////이름 유효성
	$("input[name=first_name]").on("change keyup", function(key){
		var pattern_eng = /[^a-zA-Z\s]/gi;
		var _this = $(this);
		if(key.keyCode != 8) {
			var first_name = _this.val().replace(pattern_eng, '');
			_this.val(first_name);
		}
		
		//name_check("first_name", 3);
	});

	$("input[name=last_name]").on("change keyup", function(key){
		var pattern_eng = /[^a-zA-Z\s]/gi;
		var _this = $(this);
		if(key.keyCode != 8) {
			var first_name = _this.val().replace(pattern_eng, '');
			_this.val(first_name);
		}

		//name_check("last_name", 4);
	});
	$("input[name=name_kor]").on("change keyup", function(key){
		var pattern_kor = /[^ㄱ-ㅎ가-힣\s]/gi;
		var _this = $(this);
		if(key.keyCode != 8) {
			var first_name = _this.val().replace(pattern_kor, '');
			_this.val(first_name);
		}

		//name_check("name_kor", 5);
	});


	//소속 유효성
	$("input[name=affiliation]").on("change keyup", function(key){
		var pattern_eng = /[^a-zA-Z\s]/gi;
		var _this = $(this);
		if(key.keyCode != 8) {
			var first_name = _this.val().replace(pattern_eng, '');
			_this.val(first_name);
		}

		//name_check("affiliation", 6);
	});

	$(".en_check").on("change keyup", function(key){
		var pattern_eng = /[^a-zA-Z\s]/gi;
		var _this = $(this);
		if(key.keyCode != 8) {
			var first_name = _this.val().replace(pattern_eng, '');
			_this.val(first_name);
		}
	});
	$(".kor_check").on("change keyup", function(key){
		var pattern_kor = /[^ㄱ-ㅎ가-힣\s]/gi;
		var _this = $(this);
		if(key.keyCode != 8) {
			var first_name = _this.val().replace(pattern_kor, '');
			_this.val(first_name);
		}
	});


	$("input[name=affiliation_kor]").on("change keyup", function(key){
		var pattern_kor = /[^ㄱ-ㅎ가-힣\s]/gi;
		var _this = $(this);
		if(key.keyCode != 8) {
			var first_name = _this.val().replace(pattern_kor, '');
			_this.val(first_name);
		}

		//name_check("affiliation_kor", 7);
	});

	////국가번호 유효성
	//$("input[name=nation_tel]").on("change keyup", function(key){
	//	var pattern_eng = /[^0-9]/gi;
	//	var _this = $(this);
	//	if(key.keyCode != 8) {
	//		var nation_tel = _this.val().replace(pattern_eng, '');
	//		_this.val(nation_tel);
	//	}
	//	name_check("nation_tel", 8);
	//});
	////휴대폰 유효성
	//$("input[name=phone]").on("keyup", function(key){
	//	name_check("phone", 9);
	//});

	//$("input[name=phone]").on("change", function(key){
	//	var phone = $("input[name=phone]").val();
	//	var phone_len = phone.trim().length;
	//	phone = (typeof(phone) != "undefined") ? phone : null;
	//	//if(phone_len != 13) {
	//	//	$(".red_alert").eq(9).html("format_phone");
	//	//	$(".red_alert").eq(9).css('display', 'block');
	//	//}
	//});

	//$("input[name=date_of_birth]").on("change keyup", function(key){
	//	var date_of_birth = $("input[name=date_of_birth]").val();
	//	var date_of_birth_len = date_of_birth.trim().length;
	//	date_of_birth = (typeof(date_of_birth) != "undefined") ? date_of_birth : null;

	//	if(date_of_birth || date_of_birth_len > 0) {
	//		if(date_of_birth_len != 10) {
	//			$("input[name=date_of_birth]").focus();
	//			$(".red_alert").eq(10).html("format_date_of_birth");
	//			$(".red_alert").eq(10).css('display', 'block');
	//		} else {
	//			$(".red_alert").eq(10).html("good");
	//			$(".red_alert").eq(10).css('display', 'none');
	//		}
	//	}
	//});

	////유효성 함수
	//function name_check(name, i) {
	//	
	//	var first_name = $("input[name="+name+"]").val();
	//	var first_name_len = first_name.trim().length;
	//	first_name = (typeof(first_name) != "undefined") ? first_name : null;

	//	if(!first_name || first_name_len <= 0) {
	//		if(i== 3 || i==8) {
	//			$(".red_alert").eq(i+1).css('display', 'none');
	//		} else if(i== 4 || i==9) {
	//			$(".red_alert").eq(i-1).css('display', 'none');
	//		}
	//		$("input[name="+name+"]").focus();
	//		$(".red_alert").eq(i).html("format_"+name);
	//		$(".red_alert").eq(i).css('display', 'block');
	//	} else {
	//		$(".red_alert").eq(i).html("good");
	//		$(".red_alert").eq(i).css('display', 'none');
	//	}

	//}

	//핸드폰 유효성
	$(document).on('change keyup', "input[name=phone]",function(key){
		var _this = $(this);
		if(key.keyCode != 8) {
			var phone = _this.val().replace(/[^0-9||-]/gi,'');
				//if(phone.length > 11) {
				//	phone = phone.substr(0,3) + "-" + phone.substr(3,4) + "-" + phone.substr(7,4);
				//} else if(phone.length > 7) {
				//	phone = phone.substr(0,3) + "-"+phone.substr(3,4)+"-"+phone.substr(7,4);
				//} else if(phone.length > 3) {
				//	phone = phone.substr(0,3) +"-" +phone.substr(3, 4);
				//}
			_this.val(phone);
		}
	});
	$(document).on('change keyup', ".tel_phone",function(key){
		var _this = $(this);
		if(key.keyCode != 8) {
			var phone = _this.val().replace(/[^0-9]/gi,'');
			_this.val(phone);
		}
	});
	$(document).on('change keyup', ".tel_phone2",function(key){
		var _this = $(this);
		if(key.keyCode != 8) {
			var phone = _this.val().replace(/[^0-9||-]/gi,'');
			_this.val(phone);
		}
	});

	//생년월일유효성
	$(document).on('change keyup', "input[name=date_of_birth]",function(key){
		var _this = $(this);
		if(key.keyCode != 8) {
			var date_of_birth = _this.val().replace(/[^0-9]/gi,'');
				if(date_of_birth.length > 9) {
					date_of_birth = date_of_birth.substr(0,2) + "-" + date_of_birth.substr(2,2) + "-" + date_of_birth.substr(4,4);
				} else if(date_of_birth.length > 4) {
					date_of_birth = date_of_birth.substr(0,2) + "-"+date_of_birth.substr(2,2)+"-"+date_of_birth.substr(4,4);
				} else if(date_of_birth.length > 2) {
					date_of_birth = date_of_birth.substr(0,2) +"-" +date_of_birth.substr(2,2);
				}
			_this.val(date_of_birth);
		}
	});




	//연락처 숫자와 하이픈만
	$("input[name=phone]").on("keyup", function(){
		$(this).val($(this).val().replace(/[^0-9|-]/g,""));
	});

	//자격번호 숫자만
	$(".numbers").on("keyup", function(){
		$(this).val($(this).val().replace(/[^0-9]/g,""));
	});

	//자격번호 숫자만
	$("input[name=licence_number]").on("keyup", function(){
		$(this).val($(this).val().replace(/[^0-9]/g,""));
	});
	$("input[name=specialty_number]").on("keyup", function(){
		$(this).val($(this).val().replace(/[^0-9]/g,""));
	});

	$("input[name=nutritionist_number]").on("keyup", function(){
		$(this).val($(this).val().replace(/[^0-9]/g,""));
	});


	//국가 선택 시 국가번호 append
	$("select[name=nation_no]").on("change", function(){
		var nation = $(this).find("option:selected").val();
		var nation_tel_length = $("select[name=nation_tel] option").length;
		$.ajax({
			url : PATH+"ajax/ajax_nation.php",
			type : "POST",
			data : {
				flag : "nation_tel",
				nation : nation
			},
			dataType : "JSON",
			success : function(res) {
				if(res.code == 200) {
					if(nation_tel_length >= 2) {
						$("select[name=nation_tel] option").not(":eq(0)").detach();
						$("select[name=nation_tel]").append("<option selected>"+res.tel+"</option>");
					} else {
						$("select[name=nation_tel]").append("<option selected>"+res.tel+"</option>");
					}
				}
			}
		});
	});


});



//모바일
$(document).ready(function(){

	//이메일 중복 검증
	$("input[name=mo_email]").on("change", function(){
		var email = $(this).val();
		var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
		
		if(email.match(regExp) != null) {
			$.ajax({
				url : PATH+"ajax/client/ajax_member.php", 
				type : "POST", 
				data :  {
					flag : "id_check",
					email : email
				},
				dataType : "JSON", 
				success : function(res){
					if(res.code == 200) {
						//$(".mo_red_alert").eq(0).html("good");
						//$(".mo_red_alert").eq(0).css('display', 'none');
					} else if(res.code == 400) {
						alert(locale(language.value)("used_email_msg"));
						//$(".mo_red_alert").eq(0).html("used_email_msg");
						$("input[name=mo_email]").val("").focus();
						//$(".mo_red_alert").eq(0).css('display', 'block');
						return;
					} else {
						alert(locale(language.value)("reject_msg"))
						$("input[name=mo_email]").val("").focus();
						//$(".mo_red_alert").eq(0).html("reject_msg");
						//$(".mo_red_alert").eq(0).css('display', 'block');
						return;
					}
				}
			});
		} else {
			alert(locale(language.value)("Invalid Email"));
			//$(".mo_red_alert").eq(0).html("format_email");
			//$(".mo_red_alert").eq(0).css('display', 'block');
			$(this).val("").focus();
			return;
		}
	});

	////비밀번호 유효성
	//$("input[name=mo_password]").on("change keyup", function(){
	//	pw_check(1);
	//});
	//$("input[name=mo_password2]").on("change keyup", function(){
	//	pw_check(2);
	//});

	//function pw_check(i) {
	//	var pw1 = $("input[name=mo_password]").val();
	//	var pw1_len = pw1.trim().length;
	//	pw1 = (typeof(pw1) != "undefined") ? pw1 : null;
	//	
	//	var pw2 = $("input[name=mo_password2]").val();
	//	var pw2_len = pw2.trim().length;
	//	pw2 = (typeof(pw2) != "undefined") ? pw2 : null;
	

	//	if(i==1) {
	//		if(!pw1 || pw1_len <= 0) {
	//			$("input[name=mo_password]").focus();
	//			$(".mo_red_alert").eq(1).html("format_passwrod");
	//			$(".mo_red_alert").eq(1).css('display', 'block');
	//		} else {
	//			$(".mo_red_alert").eq(1).html("good");
	//			$(".mo_red_alert").eq(1).css('display', 'none');
	//		}
	//	} else {
	//		if(!pw2 || pw2_len <= 0) {
	//			$("input[name=mo_password2]").focus();
	//			$(".mo_red_alert").eq(2).html("format_passwrod");
	//			$(".mo_red_alert").eq(2).css('display', 'block');
	//		} else {
	//			$(".mo_red_alert").eq(2).css('display', 'none');
	//		}
	//	}
	//	
	//	if(pw1_len > 0 && pw2_len > 0) {
	//		if(pw1 !== pw2) {
	//			$(".mo_red_alert").eq(2).html("inconsistency_passwrod");
	//			$(".mo_red_alert").eq(2).css('display', 'block');
	//		}
	//		else {
	//			$(".mo_red_alert").eq(2).html("good");
	//			$(".mo_red_alert").eq(2).css('display', 'none');
	//			$(".mo_red_alert").eq(1).html("good");
	//			$(".mo_red_alert").eq(1).css('display', 'none');
	//		}
	//	}
	//}

	////이름 유효성
	//$("input[name=mo_first_name]").on("change keyup", function(key){
	//	var pattern_eng = /[^a-zA-Z]/gi;
	//	var _this = $(this);
	//	if(key.keyCode != 8) {
	//		var first_name = _this.val().replace(pattern_eng, '');
	//		_this.val(first_name);
	//	}
	//	
	//	name_check("mo_first_name", 3);
	//});

	//$("input[name=mo_last_name]").on("change keyup", function(key){
	//	var pattern_eng = /[^a-zA-Z]/gi;
	//	var _this = $(this);
	//	if(key.keyCode != 8) {
	//		var first_name = _this.val().replace(pattern_eng, '');
	//		_this.val(first_name);
	//	}

	//	name_check("mo_last_name", 4);
	//});
	//$("input[name=mo_name_kor]").on("change keyup", function(key){
	//	var pattern_kor = /[^ㄱ-ㅎ가-힣]/gi;
	//	var _this = $(this);
	//	if(key.keyCode != 8) {
	//		var first_name = _this.val().replace(pattern_kor, '');
	//		_this.val(first_name);
	//	}

	//	name_check("mo_name_kor", 5);
	//});


	////소속 유효성
	//$("input[name=mo_affiliation]").on("change keyup", function(key){
	//	var pattern_eng = /[^a-zA-Z]/gi;
	//	var _this = $(this);
	//	if(key.keyCode != 8) {
	//		var first_name = _this.val().replace(pattern_eng, '');
	//		_this.val(first_name);
	//	}

	//	name_check("mo_affiliation", 6);
	//});

	//$("input[name=mo_affiliation_kor]").on("change keyup", function(key){
	//	var pattern_kor = /[^ㄱ-ㅎ가-힣]/gi;
	//	var _this = $(this);
	//	if(key.keyCode != 8) {
	//		var first_name = _this.val().replace(pattern_kor, '');
	//		_this.val(first_name);
	//	}

	//	name_check("mo_affiliation_kor", 7);
	//});

	////국가번호 유효성
	//$("input[name=mo_nation_tel]").on("change keyup", function(key){
	//	var pattern_eng = /[^0-9]/gi;
	//	var _this = $(this);
	//	if(key.keyCode != 8) {
	//		var nation_tel = _this.val().replace(pattern_eng, '');
	//		_this.val(nation_tel);
	//	}
	//	name_check("mo_nation_tel", 8);
	//});
	////휴대폰 유효성
	//$("input[name=mo_phone]").on("keyup", function(key){
	//	name_check("mo_phone", 9);
	//});

	//$("input[name=mo_phone]").on("change", function(key){
	//	var phone = $("input[name=mo_phone]").val();
	//	var phone_len = phone.trim().length;
	//	phone = (typeof(phone) != "undefined") ? phone : null;
	//	if(phone_len != 13) {
	//		$(".mo_red_alert").eq(9).html("format_phone");
	//		$(".mo_red_alert").eq(9).css('display', 'block');
	//	}
	//});

	//$("input[name=mo_date_of_birth]").on("change keyup", function(key){
	//	var date_of_birth = $("input[name=mo_date_of_birth]").val();
	//	var date_of_birth_len = date_of_birth.trim().length;
	//	date_of_birth = (typeof(date_of_birth) != "undefined") ? date_of_birth : null;

	//	if(date_of_birth || date_of_birth_len > 0) {
	//		if(date_of_birth_len != 10) {
	//			$("input[name=mo_date_of_birth]").focus();
	//			$(".mo_red_alert").eq(10).html("format_date_of_birth");
	//			$(".mo_red_alert").eq(10).css('display', 'block');
	//		} else {
	//			$(".mo_red_alert").eq(10).html("good");
	//			$(".mo_red_alert").eq(10).css('display', 'none');
	//		}
	//	}
	//});


	//핸드폰 유효성
	$(document).on('change keyup', "input[name=mo_phone]",function(key){
		var _this = $(this);
		if(key.keyCode != 8) {
			var phone = _this.val().replace(/[^0-9||-]/gi,'');
				//if(phone.length > 11) {
				//	phone = phone.substr(0,3) + "-" + phone.substr(3,4) + "-" + phone.substr(7,4);
				//} else if(phone.length > 7) {
				//	phone = phone.substr(0,3) + "-"+phone.substr(3,4)+"-"+phone.substr(7,4);
				//} else if(phone.length > 3) {
				//	phone = phone.substr(0,3) +"-" +phone.substr(3, 4);
				//}
			_this.val(phone);
		}
	});

	//생년월일유효성
	$(document).on('change keyup', "input[name=mo_date_of_birth]",function(key){
		var _this = $(this);
		if(key.keyCode != 8) {
			var date_of_birth = _this.val().replace(/[^0-9]/gi,'');
				if(date_of_birth.length > 9) {
					date_of_birth = date_of_birth.substr(0,2) + "-" + date_of_birth.substr(2,2) + "-" + date_of_birth.substr(4,4);
				} else if(date_of_birth.length > 4) {
					date_of_birth = date_of_birth.substr(0,2) + "-"+date_of_birth.substr(2,2)+"-"+date_of_birth.substr(4,4);
				} else if(date_of_birth.length > 2) {
					date_of_birth = date_of_birth.substr(0,2) +"-" +date_of_birth.substr(2,2);
				}
			_this.val(date_of_birth);
		}
	});


	//연락처 숫자와 하이픈만
	$("input[name=mo_phone]").on("keyup", function(){
		$(this).val($(this).val().replace(/[^0-9|-]/g,""));
	});

	//자격번호 숫자만
	$("input[name=mo_licence_number]").on("keyup", function(){
		$(this).val($(this).val().replace(/[^0-9]/g,""));
	});
	$("input[name=mo_specialty_number]").on("keyup", function(){
		$(this).val($(this).val().replace(/[^0-9]/g,""));
	});

	$("input[name=mo_nutritionist_number]").on("keyup", function(){
		$(this).val($(this).val().replace(/[^0-9]/g,""));
	});


	//국가 선택 시 국가번호 append
	$("select[name=mo_nation_no]").on("change", function(){
		var nation = $(this).find("option:selected").val();
		var nation_tel_length = $("select[name=mo_nation_tel] option").length;
		$.ajax({
			url : PATH+"ajax/ajax_nation.php",
			type : "POST",
			data : {
				flag : "nation_tel",
				nation : nation
			},
			dataType : "JSON",
			success : function(res) {
				if(res.code == 200) {
					if(nation_tel_length >= 2) {
						$("select[name=mo_nation_tel] option").not(":eq(0)").detach();
						$("select[name=mo_nation_tel]").append("<option selected>"+res.tel+"</option>");
					} else {
						$("select[name=mo_nation_tel]").append("<option selected>"+res.tel+"</option>");
					}
				}
			}
		});
	});

	//유효성 함수
	function name_check(name, i) {
		
		var first_name = $("input[name="+name+"]").val();
		var first_name_len = first_name.trim().length;
		first_name = (typeof(first_name) != "undefined") ? first_name : null;

		if(!first_name || first_name_len <= 0) {
			if(i== 3 || i==8) {
				$(".mo_red_alert").eq(i+1).css('display', 'none');
			} else if(i== 4 || i==9) {
				$(".mo_red_alert").eq(i-1).css('display', 'none');
			}
			$("input[name="+name+"]").focus();
			name = name.replace("mo_", "");
			$(".mo_red_alert").eq(i).html("Invalid_"+name);
			$(".mo_red_alert").eq(i).css('display', 'block');
		} else {
			$(".mo_red_alert").eq(i).html("good");
			$(".mo_red_alert").eq(i).css('display', 'none');
		}

	}


});

function inputCheck(formData, check_type) {
	var data = {};
	var length_50 = ["email", "first_name", "last_name", "department", "licence_number"];

	var inputCheck = true;
	
	$.each(formData, function(key, value){
		var ok = value["name"];
		var ov = value["value"];

		if(ov == "" || ov == null || ov == "undefinded") {
			
			if(ok == "email" || ok == "password" || ok == "re_password" || ok == "first_name" || ok == "last_name" || ok == "phone"){
				if(ok == "email") {
					alert(locale(language.value)("check_email"));
				} else if(ok == "password") {
					alert(locale(language.value)("check_password"));
				} else if(ok == "re_password") {
					alert(locale(language.value)("check_password"));
				} else if(ok == "first_name") {
					alert(locale(language.value)("check_first_name"));
				} else if(ok == "last_name") {
					alert(locale(language.value)("check_last_name"));
				} else {
					alert(locale(language.value)("check_phone"));
				}

				$("input[name="+ok+"]").focus();
				inputCheck = false;
				return false;
			}
			
		} else {
			if((length_50.indexOf(ok)+1) && ov.length > 50) {
				alert(ok+locale(language.value)("under_50"));
				$("input[name="+ok+"]").focus();
				inputCheck = false;
				return false;
			} else if(ok == "password" && ov.length < 6) {
				alert(ok+locale(language.value)("over_6"));
				$("input[name="+ok+"]").focus();
				inputCheck = false;
				return false;
			} else if(ok == "re_password" && ov != $("input[name=password]").val()) {
				alert(locale(language.value)("mismatch_password"));
				$("input[name="+ok+"]").focus();
				inputCheck = false;
				return false;
			} else if(ok == "affiliation" && ov.length > 100) {
				alert(ok+locale(language.value)("under_100"));
				$("input[name="+ok+"]").focus();
				inputCheck = false;
				return false;
			} else if(ok == "phone" && ov.length > 20) {
				alert(ok+locale(language.value)("under_20"));
				$("input[name="+ok+"]").focus();
				inputCheck = false;
				return false;
			}
		}

		data[ok] = ov;
	});

	if(inputCheck){
		if($("select[name=nation_no]").val() == null || $("select[name=nation_no]").val() == "") {
			alert(locale(language.value)("check_nation"));
			inputCheck = false;
			return false;
		} 
		if(check_type === 0) {
			if($("input[name=terms1]").is(":checked") == false) {
				alert(locale(language.value)("check_terms1"));
				inputCheck = false;
				return false;
			} else if($("input[name=terms2]").is(":checked") == false) {
				alert(locale(language.value)("check_terms2"));
				inputCheck = false;
				return false;
			}
		}
	}

	return {
		data : data,
		status : inputCheck
	}
}

