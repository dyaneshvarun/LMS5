var emerr = 1, perr = 1;
var apperr = "<span class='glyphicon glyphicon-remove form-control-feedback'></span><span class='help-block'>";
function dispErr(tag,msg){
	$(tag).closest("div").addClass("has-error").addClass("has-feedback");
	$(tag).closest("div").find('span').remove();
	$(tag).closest("div").append(apperr + msg + "</span>");
}
function clearErr(tag){
	$(tag).closest("div").removeClass("has-error").removeClass("has-feedback");
	$(tag).closest("div").find('span').remove();
}
function noReason(tag){
		var reso = $(tag).val();
		if(reso == ''){
			reserr = 1;
			dispErr("#res","Reason Field Empty");
		}
		else{
			reserr = 0;
			clearErr("#res");
		}
	}
$(document).ready(function(){
	$("#nod").focusout(function(){
		var nod = $("#nod").val();
		if(nod == ''){
			noderr = 1;
			dispErr("#nod","No of Days Empty");
		}else if(!$.isNumeric(nod)){
			noderr = 1;
			dispErr("#nod","Not a valid Integer");
		}else{
			noderr = 0;
			$("#datetab").find("tbody").remove();	
			$("#datetab").append("<tbody></tbody>");			
			for(var i=nod;i>0;i--){
				var temp = "<tr><td><input type='input' class='form-control datepickee datepickf' id='fdate"+i+"' required></td><td><input type='input' class='form-control' id='purpose"+i+"'></td>";
				$("#datetab tbody").append(temp);
			
			}$("#datetab tbody").append("<tr><td><input type=\"Submit\" id=\" submitButton \">");
		}
	});
	
	$(document).on('focusin','.datepickee',(function(){
		$(this).datepicker(
			{dateFormat: 'dd/mm/yy', minDate : new Date(), changeMonth: true, changeYear: true, yearRange: '2016:2019'}
		);
	}));
	
	$("#fsub").submit(function(e){
		e.preventDefault();
		var purpose = new Array();
		for(var i=$("#nod").val();i>0;i--){
			purpose.push($("#purpose"+i+"").val());
		}
		var purposes = 0;
		var dates = 0;
		var date = new Array();
	$('.datepickf').each(function(){
			var tdate = $(this).val();
			if(tdate == ''){
				fdayFlag = 1;
			}
			var temp = $.datepicker.parseDate("dd/mm/yy",tdate);
			tdate = $.datepicker.formatDate("yy-mm-dd",temp);
			date.push(tdate);
			//purposes = JSON.stringify(purpose);
			//dates = JSON.stringify(pdates);
		});
		$.post("public-holidays2.php",{
			PurposesArray:purpose,
			DateArray:date
		},function(data,status)
		{
			alert(data);
			alert(status);
		});
	});
	
});
