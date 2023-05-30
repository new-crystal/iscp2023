(function($){
    $(document).ready(function() {
        $(".smarteditor2").each( function(index){
            var get_id = $(this).attr("id");

            if( !get_id || $(this).prop("nodeName") != 'TEXTAREA' ) return true;

            nhn.husky.EZCreator.createInIFrame({
                oAppRef: oEditors,
                elPlaceHolder: get_id,
                sSkinURI: g5_editor_url+"/SmartEditor2SkinNonPicture_en_US.html",
                htParams : {
                    bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseVerticalResizer : false,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseModeChanger : false,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                    bSkipXssFilter : true,		// client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
                    //aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
                    fOnBeforeUnload : function(){
                        //alert("완료!");
                    }
                }, //boolean,
                fOnAppLoad : function(){
                    //예제 코드
                    //oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
                    oEditors.getById[get_id].setDefaultFont("돋움", 12);  // 기본 글꼴 설정 추가
                },
                fCreator: "createSEditor2"
            });
        });
    });
})(jQuery);


//window.onload = function () {
// var onChangeEditor = function (e) {

//  /* 에디터 내용 */
//  var editor_data = e.currentTarget.innerHTML;
//	console.log("aaa");
// }

// /* 스마트 에디터 선택 */
//// var editor = $('iframe[src="smart_editor2_inputarea.html"]').contents().find("iframe[name=se2_iframe]").contents().find('.se2_inputarea');
//var editor = $('iframe[src="'+g5_editor_url+'/SmartEditor2Skin.html"]').contents().find("iframe[name=se2_iframe]").contents().find('.se2_inputarea');
// /* 스마트 에디터 키업 이벤트*/
// $(editor).keyup(onChangeEditor);

//	editor.keyup(function(){
//		console.log("a");
//	});
//}