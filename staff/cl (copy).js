var opterr = 1,noderr = 1,d1err =1, d2err =1, reserr=1;
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

$(document).ready(function(){
	$("#lt").on('change',function(){
		var opt = $("#lt").val();
		if(opt == 'none'){
			opterr = 1;
			dispErr('#lt',"Please Select a Valid Leave Type");
			$("#date1").prop('disabled',true);
			$("#date2").prop('disabled',true);
			$("#res").prop('disabled',true);
			$("#addr").prop('disabled',true);
		}
		else{
			opterr = 0;
			clearErr("#lt");
			var sta_id = $("#sid").val();
			$.post("qengine.php",
			{
				op:1,
				type: opt
			},function(data,status){
				var res = $.parseJSON(data);
				$("#bal").val(res['total'] - res['avail']);
				$("#tot").val(res['avail']);
				$("#nod").prop('disabled',false);
				$("#date1").prop('disabled',false);
				//$("#date2").prop('disabled',false);
				$("#res").prop('disabled',false);
				$("#addr").prop('disabled',false);
			});
		}
	});
	$("#date1,#date2").focusin(function(){
		$(this).datepicker(
			{dateFormat: 'dd/mm/yy', minDate : new Date(), changeMonth: true, changeYear: true, yearRange: '2016:2017'}
		);
	});
	$("#nod").change(function(){
		var nod = $("#nod").val();
		$("#date1,#date2").val("");
		if(nod > 1){
			//$("#date2").prop('disabled',false);			
		}
		else{
			$("#date2").prop('disabled',true);	
		}
	});
	$("#date1").change(function(){
		var date1 = new Date($('#date1').datepicker('getDate'));
		//var date2 = new Date($('#date2').datepicker('getDate'));
		var temp = date1;
		var count=$("#nod").val();
		alert(count);
		var t1 = 1;
		while(t1 < count){
			temp.setDate(temp.getDate() + 1);
			var day = temp.getDay();
			if(day!=0 && day!=6){
				t1++;
			}
			
		}
		$("#date2").val($.datepicker.formatDate("dd/mm/yy",temp));
		/*while(temp <= date2){
			var day = temp.getDay();
			if(day!=0 && day!=6){
				count++;
			}
			temp.setDate(temp.getDate() + 1);
		}*/
		//$("#nod").val(count);
		var bal = $("#bal").val();
		/*if(bal < count){
			noderr = 1;
			dispErr("#nod","Not enough Leave Days available");
			return;
		}
		else{
			noderr = 0;
			clearErr("#nod");
		}*/
	});
	$("#date1").change(function(){
		var td1 = $("#date1").val();
		if(td1 == ''){
			d1err = 1;
			dispErr("#date1","Enter Select a Valid Date");
		}
		else{
			d1err = 0; clearErr("#date1");
		}
	});
	$("#date2").change(function(){
		var td2 = $("#date2").val();
		if(td2 == ''){
			d2err = 1;
			dispErr("#date2","Enter Select a Valid Date");
		}
		else{
			d2err = 0; clearErr("#date2");
		}
	});
	$("#res").focusout(function(){
		var reso = $("#res").val();
		if(reso == ''){
			reserr = 1;
			dispErr("#res","Reason Field Empty");
		}
		else{
			reserr = 0;
			clearErr("#res");
		}
	});
	$("#fsub").submit(function(e){
		e.preventDefault();
		var td1 = $("#date1").val();
		if(td1 == ''){
			d1err = 1;
			dispErr("#date1","Enter Select a Valid Date");
		}
		else{
			d1err = 0; clearErr("#date1");
		}
		var td2 = $("#date2").val();
		if(td2 == ''){
			d2err = 1;
			dispErr("#date2","Enter Select a Valid Date");
		}
		else{
			d2err = 0; clearErr("#date2");
		}
		if(opterr == 0&& noderr == 0 && reserr == 0 && d1err == 0 && d2err ==0){
			var ltype = $("#lt").val();
			var fdate = $("#date1").val();
			var temp = $.datepicker.parseDate("dd/mm/yy",fdate);
			fdate = $.datepicker.formatDate("yy-mm-dd",temp);
			var tdate = $("#date2").val();
			temp = $.datepicker.parseDate("dd/mm/yy",tdate);
			tdate = $.datepicker.formatDate("yy-mm-dd",temp);
			var res = $("#res").val();
			var addr = $("#addr").val();
			$.post("qengine.php",{
				op:2,
				lt:ltype,
				fd:fdate,
				td:tdate,
				re:res,
				ad:addr
			},function(data,status){
				alert(data);
				if(data == 1){
					alert("Leave Requested Successfully");
				}
			});
		}
		else{
			alert("Form Not Valid");
		}
	});
});
