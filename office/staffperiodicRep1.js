
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
		/*$.post("countDays.php",
			{
				staff : $("staffid").val()
			},function(data1,status){
                            
                       alert(data1);
		});*/
		$.post("staffwiseperiodicRep1.php",
			{
				fdate:leaveDate[0],
				tdate:leaveDate[1],
				op : "CL",
				nod:$("#staffid").val()
			},function(data,status){
                            
                        document.getElementById("output1").innerHTML = data;
		});
		$.post("staffwiseperiodicRep1.php",
			{
				fdate:leaveDate[0],
				tdate:leaveDate[1],
				op : 'RH',
				nod:$("#staffid").val()
			},function(data,status){
                            
                        document.getElementById("output2").innerHTML = data;
		});
		$.post("staffwiseperiodicRep1.php",
			{
				fdate:leaveDate[0],
				tdate:leaveDate[1],
				op : 'SCL',
				nod:$("#staffid").val()
			},function(data,status){
                            
                        document.getElementById("output3").innerHTML = data;
		});
		$.post("staffwiseperiodicRep1.php",
			{
				fdate:leaveDate[0],
				tdate:leaveDate[1],
				op : 'OD',
				nod:$("#staffid").val()
			},function(data,status){
                            
                        document.getElementById("output4").innerHTML = data;
		});
		$.post("staffwiseperiodicRep1.php",
			{
				fdate:leaveDate[0],
				tdate:leaveDate[1],
				op : 'ML',
				nod:$("#staffid").val()
			},function(data,status){
                            
                        document.getElementById("output5").innerHTML = data;
		});
		$.post("staffwiseperiodicRep1.php",
			{
				fdate:leaveDate[0],
				tdate:leaveDate[1],
				op : 'EL',
				nod:$("#staffid").val()
			},function(data,status){
                            
                        document.getElementById("output6").innerHTML = data;
		});
			//alert(leaveDate);
	});///*/
		

});