
$(document).ready(function(){
	
	$(document).on('focusin','.datepickee',(function(){
		$(this).datepicker(
			{dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, yearRange: '2016:2019'}
		);
	}));
	$("#clearButton").click(
	
	function(){
		$("#fdate").val('');
		$("#tdate").val('');
	}
	
	);
	$("#fsub").submit(function(e){
		e.preventDefault();
		var leaveDate = new Array();
		var compDate = new Array();
		$('.datepickf').each(function(){
			var tdate = $(this).val();
			if(tdate == ''){
				fdayFlag = 1;
			}
			var temp = $.datepicker.parseDate("dd/mm/yy",tdate);
			tdate = $.datepicker.formatDate("yy-mm-dd",temp);
			leaveDate.push(tdate);
		});
		$('.datepickf').each(function(){
			var tdate = $(this).val();
			if(tdate == ''){
				cdayFlag = 1;
			}
			var temp = $.datepicker.parseDate("dd/mm/yy",tdate);
			tdate = $.datepicker.formatDate("yy-mm-dd",temp);
			compDate.push(tdate);
		});
		alert(compDate);
		alert(leaveDate);
		$.post("periodicRep1.php",
			{
				fdate:leaveDate[0],
				tdate:leaveDate[1]
			},function(data,status){
				alert(data);
				if(data > 0){
					alert("Login Success");
					window.location.replace("index.php");
				}
				else{
					alert("Login Failed: Check Network");
				}
			});

});
});