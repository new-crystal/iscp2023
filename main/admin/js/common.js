$(document).ready(function(){

    // 검색창 내 Input Value 정형화
    $("form[name=search_form]").on("keyup", "input", function(key){
        if(key.keyCode == 8){
            return false;
        }

        $(this).val(convertInputValue($(this)));
    });

    // 검색 버튼 클릭
    $("form[name=search_form]").on("click", ".search_btn", function(){
        var data = $("form[name=search_form]").serializeArray();

        if(!validCheck(data)){
            return false;
        }

        $("form[name=search_form]").submit();
    });

});

// 형식에 맞춰 Input 데이터 정형화
function convertInputValue(target){
    var t = target.data("type");
        t = (t != null && t != "" && typeof(t) != "undefined") ? t : "";

    var v = target.val();
        v = (v != null && v != "" && typeof(v) != "undefined") ? v : "";

    if(t == "date"){
        v = v.replace(/[^0-9]/gi, "");

        if(v.length > 6){
            v = v.substr(0,4)+"-"+v.substr(4,2)+"-"+v.substr(6,2);
        }else if(v.length > 4){
            v = v.substr(0,4)+"-"+v.substr(4,2);
        }
    }else if(t == "number"){
        v = v.replace(/[^0-9]/gi, "");
    }else if(t == "phone"){
        v = v.replace(/[^0-9\+\-\s]/gi, "");
    }else if(t == "string"){
        v = v.replace(/[^a-zA-Zㄱ-ㅎㅏ-ㅢ가-힇\s]/gi, "");
    }

    return v;
}

// 검색 유효성
function validCheck(data){
    var valid = true;

    $.each(data, function(k,v){
        var key = v.name;
        var val = v.value;
        var type = $("input[name="+key+"]").data("type");
            type = (type != null && type != "" && typeof(type) != "undefined") ? type : "";

        if(type != "date" && val != "" && val.length < 2){
            if(key != "attendance_type") {
                $("input[name="+key+"]").focus();
                alert("최소 2자 이상 입력해주세요.");
                valid = false;
                return false;
            }
        }else if(type == "date" && val != "" && validDate(val) == false){
            $("input[name="+key+"]").focus();
            alert("날짜 형식이 올바르지 않습니다.");
            valid = false;
            return false;
        }
    });

    return valid;
}

// 날짜 유효성
function validDate(vDate){ 
    var vValue = vDate; 
    var vValue_Num = vValue.replace(/[^0-9]/g, ""); //숫자를 제외한 나머지는 예외처리 합니다. 
    
    //_fnToNull 함수는 아래 따로 적어두겠습니다. 
    if (vValue_Num == "") {
        return false;
    } 

    //8자리가 아닌 경우 false 
    if (vValue_Num.length != 8) {
        return false; 
    } 

    //8자리의 yyyymmdd를 원본 , 4자리 , 2자리 , 2자리로 변경해 주기 위한 패턴생성을 합니다.
    var rxDatePattern = /^(\d{4})(\d{1,2})(\d{1,2})$/; 
    var dtArray = vValue_Num.match(rxDatePattern); 
    
    if(dtArray == null){ 
        return false; 
    } 
    
    //0번째는 원본 , 1번째는 yyyy(년) , 2번재는 mm(월) , 3번재는 dd(일) 입니다. 
    
    dtYear = dtArray[1]; 
    dtMonth = dtArray[2]; 
    dtDay = dtArray[3]; 
    
    //yyyymmdd 체크 
    
    if(dtMonth < 1 || dtMonth > 12){ 
        return false; 
    }else if(dtDay < 1 || dtDay > 31){
        return false; 
    } else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31) { 
        return false; 
    } else if (dtMonth == 2) { 
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0)); 
        if(dtDay > 29 || (dtDay == 29 && !isleap)){
            return false; 
        }
    }
    return true; 
}

// datepicker 값 세팅
function setDate(name, date){
	$("[name=" + name + "]").datepicker().data("datepicker").selectDate(new Date(date));
}

//엑셀다운로드 title=파일명, html=html태그
function fnExcelReport(title, html) {
    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
    tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
    tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    tab_text = tab_text + "<table border='1px'>";

    // var exportTable = $('#' + id).clone();
    var exportTable = html;

    // exportTable.find('input').each(function (index, elem) { $(elem).remove(); });
    tab_text = tab_text + exportTable;

    tab_text = tab_text.replace(/▲|▼|/g, "");//remove if u want links in your table
    tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text = tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // remove input params
    tab_text = tab_text.replaceAll("+","&nbsp+");

    console.log(tab_text);

    var data_type = 'data:application/vnd.ms-excel';
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    var fileName = title + '.xls';
    //Explorer 환경에서 다운로드
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        if (window.navigator.msSaveBlob) {
            var blob = new Blob([tab_text], {
            type: "application/csv;charset=utf-8;"
        });
        navigator.msSaveBlob(blob, fileName);
        }
    } else {
        var blob2 = new Blob([tab_text], {
        type: "application/csv;charset=utf-8;"
        });
        var filename = fileName;
        var elem = window.document.createElement('a');
        elem.href = window.URL.createObjectURL(blob2);
        elem.download = filename;
        document.body.appendChild(elem);
        elem.click();
        document.body.removeChild(elem);
    }
}

// 숫자 타입에서 쓸 수 있도록 format() 함수 추가
Number.prototype.format = function(){
	var _this = this;
	if(_this==0) return 0;
	var n = _this.toString().replace(/[^0-9]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ',');
	return n;
};

// 문자열 타입에서 쓸 수 있도록 format() 함수 추가
String.prototype.format = function(){
	var _this = this;
	var num = parseInt(_this.replace(/[^0-9]/g, ""));
	if(num===0) return "0";
	if(!num) return "";
	if(isNaN(num)) return "0";
	return num.format();
};

String.prototype.unformat = function(){
	var _this = this;
	var num = parseInt(_this.replace(/[^0-9]/g, ""));
	if(num===0) return 0;
	if(!num) return "";
	if(isNaN(num)) return 0;
	return num;
};
