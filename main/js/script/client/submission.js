$(document).ready(function(){
	//페이지 이동시 확인창
	$(window).on("beforeunload", function(){
		return locale(language.value)("leave_page");
	});

	//저자 국가 선택 시 국가번호 append
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
					if(nation_tel_length => 2) {
						$("select[name=nation_tel] option").detach();
						$("select[name=nation_tel]").append("<option selected>"+res.tel+"</option>");
					} else {
						$("select[name=nation_tel]").append("<option selected>"+res.tel+"</option>");
					}
				}
			}
		});
	});

	//공동저자 국가 선택 시 국가번호 append
	$(document).on("change", ".co_nation",function(){
		var nation = $(this).find("option:selected").val();
		var nation_tel_length = $("select[name^=co_nation_tel]").length;
        var co_count = $(this).data("count");

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
					if(nation_tel_length => 2) {
						$("select[name=co_nation_tel"+co_count+"] option").detach();
						$("select[name=co_nation_tel"+co_count+"]").append("<option selected>"+res.tel+"</option>");
					} else {
						$("select[name=co_nation_tel"+co_count+"]").append("<option selected>"+res.tel+"</option>");
					}
				}
			}
		});
	});

    //영문만 입력 및 대문자 변환
	$(".uppercase").on("keyup", function(){
		$(this).val($(this).val().replace(/[^a-z|A-Z| ]/g,""));
		$(this).val($(this).val().toUpperCase());
	});
});