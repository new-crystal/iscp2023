$(document).ready(function(){
    $(document).on("click", ".green_btn", function(){
		
		//var process = inputCheck("insert");
		//var status = process.status;
		//var data = process.data;
//        console.log(data);
//        for (let key of data.keys()) {
//          console.log(key);
//        }
//            console.log("value");
//        // FormData의 value 확인
//        for (let value of data.values()) {
//          console.log(value);
//        }


		var email = $("#email").text();
		var first_name = $("input[name=first_name]").val();
		var last_name = $("input[name=last_name]").val();
		var name_kor = $("#name_kor").text();
		var nation = $("#nation").text();
		var nation_no = $("#nation_no").val();

		//db에서는 category가 member_type
		var category = $("#category").text();

		var attendance_type = $("input[name=attendance_type]:checked").val();
		var registration_type= $("input[name=registration_type]:checked").val();
		var c_type1 = $("input[name=c_type1]:checked").val();
		var c_type3 = $("input[name=c_type3]:checked").val();
		//var payment_methods= $("input[name=payment_methods]:checked").val();


		var welcome_reception_yn = $("input[name=welcome_reception]:checked").val(); 
		//2022-05-06 추가 된 부분
		var day1_luncheon_yn = $("input[name=day1_luncheon]:checked").val(); 
		var day2_breakfast_yn = $("input[name=day2_breakfast]:checked").val();
		var day2_luncheon_yn = $("input[name=day2_luncheon]:checked").val();
		var day3_breakfast_yn = $("input[name=day3_breakfast]:checked").val();
		var day3_luncheon_yn = $("input[name=day3_luncheon]:checked").val();


		var data = new FormData();

		var registration_idx = $("input[name=registration_idx]").val();

		if(registration_idx) {
			//수정
			data.append("registration_idx", registration_idx);
			data.append("sql_type" , "UPDATE");
		} else {
			//삽입
			data.append("sql_type" , "INSERT");
		}
	
		data.append("flag", "registration");
		data.append("email", email);
		data.append("name_en", name_en);
		data.append("name_kor", name_kor);
		data.append("last_name", last_name);
		data.append("first_name", first_name);
		data.append("nation", nation);
		data.append("nation_no", nation_no);
		data.append("member_type", category);
		//data.append("attendance_type", attendance_type);
		//data.append("registration_type", registration_type);
		data.append("price", c_type1);
		data.append("welcome_reception", c_type3);
		//data.append("payment_methods", payment_methods);


		data.append("welcome_reception_yn", welcome_reception_yn);
		//2022-05-06 추가 된 부분
		// 저녁 먹는지
		data.append("day1_luncheon_yn", day1_luncheon_yn);
		data.append("day2_breakfast_yn", day2_breakfast_yn);
		data.append("day2_luncheon_yn", day2_luncheon_yn);
		data.append("day3_breakfast_yn" , day3_breakfast_yn);
		data.append("day3_luncheon_yn", day3_luncheon_yn);

		//어떻게 이 행사를 알게 됐는지
		var register_path ="";

		$("input:checkbox[name='register_path']").each(function(){
			
			if(this.checked) {
				register_path += this.value + ",";
			}
		});


		if(register_path == "") {
			alert("How did you hear about the ISCP 2023?");
			return;
		}

		data.append("register_path", register_path);
		//기타 포함

		var register_path8 = $("#register_path8:checked").val();

		if(register_path8 == 7) {
			var register_path_others = $("input[name=register_path_others]").val();
			if(!register_path_others) {
				
				alert("check others");
				return;
			}
			data.append("register_path_others", register_path_others);
		}

		var invitation = $("#invitation").is(":checked");

		if(invitation == true) {
			if(Mobile() == false) {
				data.append("invitation_first_name", $("input[name=invitation_first_name]").val());
				data.append("invitation_last_name", $("input[name=invitation_last_name]").val());
				data.append("invitation_nation_no", $("#invitation_nation_no option:selected").val());
				data.append("invitation_address", $("input[name=invitation_address]").val());
				data.append("invitation_passport", $("input[name=invitation_passport]").val());
				data.append("invitation_date_of_birth", $("input[name=invitation_date_of_birth]").val());
				data.append("invitation_date_of_issue", $("input[name=invitation_date_of_issue]").val());
				data.append("invitation_date_of_expiry", $("input[name=invitation_date_of_expiry]").val());
				data.append("invitation_length_of_visit", $("input[name=invitation_length_of_visit]").val());

			} else {
				data.append("invitation_first_name", $("input[name=mo_invitation_first_name]").val());
				data.append("invitation_last_name", $("input[name=mo_invitation_last_name]").val());
				data.append("invitation_nation_no", $("#mo_invitation_nation_no option:selected").val());
				data.append("invitation_address", $("input[name=mo_invitation_address]").val());
				data.append("invitation_passport", $("input[name=mo_invitation_passport]").val());
				data.append("invitation_date_of_birth", $("input[name=mo_invitation_date_of_birth]").val());
				data.append("invitation_date_of_issue", $("input[name=mo_invitation_date_of_issue]").val());
				data.append("invitation_date_of_expiry", $("input[name=mo_invitation_date_of_expiry]").val());
				data.append("invitation_length_of_visit", $("input[name=mo_invitation_length_of_visit]").val());
			}
			
			invitation = "Y";
		} else {
			invitation = "N";
		}
		
		data.append("invitation_yn", invitation);

		//if(status) {
			//if(confirm(locale(language.value)("confirm_msg"))) {
				$.ajax({
					url : PATH+"ajax/client/ajax_registration.php",
					type : "POST",
				    data : data,
					dataType : "JSON",
                    contentType:false,
                    processData:false,
					success : function(res){
						console.log(res);
						if(res.code == 200) {
							$(window).off("beforeunload");
							window.location.replace(PATH+"registration2.php?idx="+res.registration_idx);
							//if(res.payment_methods == 0) {
								//window.location.replace(PATH+"registration2.php?idx="+res.registration_idx);
							//} else {
								//window.location.replace(PATH+"registration_account.php?idx="+res.registration_idx+"&nation_no="+res.nation_no);
							//}
						} else if(res.code == 400){
							alert(locale(language.value)("error_registration"));
							return false;
						} else if(res.code == 401){
							alert(locale(language.value)("already_registration"));
							window.location.replace(PATH+"mypage_registration.php");
							return false;
						} else {
							alert(locale(language.value)("reject_msg")+locale(language.value)("retry_msg"));
							return false;
						}
					}
				});
			//}
		//}	
	});
    
	//페이지 이동시 확인창
	//$(window).on("beforeunload", function(){
	//	return locale(language.value)("leave_page");
	//});

	//필수 입력 시 버튼 활성화
	$(".required").on("change", function(){
		var result = requiredCheck();

		if(result) {
			$(".next_btn").addClass("submit_btn");
		} else {
			$(".next_btn").removeClass("submit_btn");
		}
	});
	//모바일 여부
	function Mobile() {return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);}
});

	

function payment(){
	var frm = document.regForm;
	var price = $("input[name=price]").val();

	if(price == "0"){
		window.location.replace("./registration3.php");
	}else{
		var payment_pop = window.open("", "payment", "resizable=yes,scrollbars=yes,width=820,height=600");
		frm.target = "payment";
		frm.submit();
	}
}

function requiredCheck() {
	var required = $(".required");
	for(i=0; i<required.length; i++) {
		if($(required[i]).val() == "" || $(required[i]).val() == null) {
			return false;
		}
	}
	if(!$("input[name=attendance_type]").is(":checked") || !$("input[name=rating]").is(":checked") || !$("input[name=registration_type]").is(":checked")) {
		return false;
	}

	return true;
}
function inputCheck(check_type) {
	var data = new FormData();
	var length_50 = ["email", "first_name", "last_name", "department", "licence_number"];

	var formData = $("form[name=registration_form]").serializeArray();
	var inputCheck = true;
	$.each(formData, function(key, value){
		var ok = value["name"];
		var ov = value["value"];


		if(ov == "" || ov == null || ov == "undefinded") {
			if(ok == "email" || ok == "password" || ok == "first_name" || ok == "last_name" || ok == "phone") {
				if(ok == "email") {
					alert(locale(language.value)("check_email"));
				} else if(ok == "password") {
					alert(locale(language.value)("check_password"));
				} else if(ok == "first_name") {
					alert(locale(language.value)("check_first_name"));
				} else if(ok == "last_name") {
					alert(locale(language.value)("check_last_name"));
				} else if(ok == "phone") {
					alert(locale(language.value)("check_phone"));
				}

				$("input[name="+ok+"]").focus();
				inputCheck = false;
				return false;
			}
		} else {
			if((length_50.indexOf(ok)+1) && ov.length > 50) {
				alert(ok+locale(language.value)("under_50"));
				inputCheck = false;
				return false;
			} else if(ok == "password" && ov.length < 6) {
				alert(ok+locale(language.value)("over_6"));
				inputCheck = false;
				return false;
			} else if(ok == "affiliation" && ov.length > 100) {
				alert(ok+locale(language.value)("under_100"));
				inputCheck = false;
				return false;
			} else if(ok == "phone" && ov.length > 20) {
				alert(ok+locale(language.value)("under_20"));
				inputCheck = false;
				return false;
			}
		}
		data.append(ok, ov);
	});

	if(inputCheck) {
		if(check_type == "insert") {
			if(!$("input[name=attendance_type]").is(":checked")) {
				alert(locale(language.value)("check_attendance_type"));
				inputCheck = false;
				return false;
			}
			if(!$("input[name=rating]").is(":checked")) {
				alert(locale(language.value)("check_review"));
				inputCheck = false;
				return false;
			}
			if(!$("input[name=member_status]").is(":checked")) {
				alert(locale(language.value)("check_member_status"));
				inputCheck = false;
				return false;
			}
			if(!$("input[name=registration_type]").is(":checked")) {
				alert(locale(language.value)("check_registration_type"));
				inputCheck = false;
				return false;
			}
			if($("#radio1").is(":checked") && !$("input[name=org]").is(":checked")) {
				alert(locale(language.value)("check_applied_org"));
				inputCheck = false;
				return false;
			}
			if($('select[name=member_type] option:selected').val() == '9' || $('select[name=member_type] option:selected').val() == '10' || $('select[name=member_type] option:selected').val() == '12') {
                if(!$("input[name=identification_file]").val()){
                    alert(locale(language.value)("check_identification_file"));
                    inputCheck = false;
                    return false;                    
                }
			}
			
		}

		if($("select[name=nation_no]").val() == null || $("select[name=nation_no]").val() == "") {
			alert(locale(language.value)("check_nation"));
			inputCheck = false;
			return false;
		}

		var memberType = $("select[name=member_type] option:selected").text();
		var registerPath = $("select[name=register_path] option:selected").text();
        var etc = $('.etc1').val();
		memberType = (memberType != null && typeof(memberType) != "undefined") ? memberType : "";
		registerPath = (registerPath != null && typeof(registerPath) != "undefined") ? registerPath : "";
		etc = (etc != null && typeof(etc) != "undefined") ? etc : "";

		if(memberType == "Choose"){
			alert(locale(language.value)("check_member_type"));
			inputCheck = false;
			return false;
		}

		if(registerPath == "Choose"){
			alert(locale(language.value)("check_register_path"));
			inputCheck = false;
			return false;
		}
	}

	data.append("member_type",memberType);
	data.append("register_path",registerPath);
	data.append("etc",etc);
	data.append("flag", "registration");
    if($("input[name=identification_file]").val()){
	    data.append("identification_file", $("input[name=identification_file]")[0].files[0]);
    }
    
	return {
		data : data,
		status : inputCheck
	}
}