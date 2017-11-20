
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
		$('.datepickf').each(function(){
			var tdate = $(this).val();
			var temp = $.datepicker.parseDate("dd/mm/yy",tdate);
			tdate = $.datepicker.formatDate("yy-mm-dd",temp);
			leaveDate.push(tdate);
		});
		
		$.post("periodicRep1.php",
			{
				fdate:leaveDate[0],
				tdate:leaveDate[1]
			},function(data,status){
                           // alert(data);
                        document.getElementById("output").innerHTML = data;
			});
			//alert(leaveDate);
			});///*/
		

});