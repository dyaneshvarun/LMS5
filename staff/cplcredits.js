$(document).ready(function(){
	$("#date1,#date2").focusin(function(){
		
		$(this).datepicker(
			{dateFormat: 'dd/mm/yy',  changeMonth: true, changeYear: true, yearRange: '2016:2017'}
		);
	});
	$("#submitButton").on('click',function(e){
		e.preventDefault();
		var reason = $("#reason").val();
		var staff = $("#sid").val();
		if(reason=='')alert("Enter a valid Reason");
		else
		{
			var cpdate = new Date($('#date1').datepicker('getDate'));
			var dbDate = $.datepicker.formatDate("yy--mm--dd",cpdate);
			if(cpdate==''||cpdate=="mm/dd/yyyy") alert("Enter a valid date");
			else 
			{
				$.post("qengine.php",{
					cpdate : dbDate,
					reason : reason,
					staffid : staff,
					op:18
				},function(data,status)
				{
					console.log(data);
					if(data=='')alert("CPL is waiting for its clearance at HOD Panel");
					else alert(data);
					window.location.replace("cplcredits.php");
				});
			}
		}
		
	});
});