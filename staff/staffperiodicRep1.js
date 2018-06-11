
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
				op : 'CL',
				nod:$("#staffid").val()
			},function(data,status){
                        document.getElementById("output1").innerHTML = data;
		});
		$.post("staffwiseperiodicRep1.php",
			{
				fdate:leaveDate[0],
				tdate:leaveDate[1],
				op : "RH",
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
		$.post("staffwiseperiodicRep1.php",
			{
				fdate:leaveDate[0],
				tdate:leaveDate[1],
				op : 'EL',
				nod:$("#staffid").val()
			},function(data,status){    
                        document.getElementById("output6").innerHTML = data;
						setTimeout(function(){ 
							var clTotal = 0;
							var clTable = document.getElementById("CLT1");
							for(var i=1;clTable!=null&&i<=clTable.rows.length-1;i++)clTotal+=parseFloat($("#CL"+i).html());
							document.getElementById("clt").innerHTML=clTotal + "/12";
							
							var rhTotal = 0;
							var rhTable = document.getElementById("RHT1");
							for(var i=1;rhTable!=null&&i<=rhTable.rows.length-1;i++)rhTotal+=parseFloat($("#RH"+i).html());
							document.getElementById("rht").innerHTML=rhTotal + "/3";
							var odTotal = 0;
							var odTable = document.getElementById("ODT1");
							for(var i=1;odTable!=null&&i<=odTable.rows.length-1;i++)odTotal+=parseFloat($("#OD"+i).html());
							document.getElementById("odt").innerHTML=odTotal + "";
							var mlTotal = 0;
							var mlTable = document.getElementById("MLT1");
							for(var i=1;mlTable!=null&&i<=mlTable.rows.length-1;i++)mlTotal+=parseFloat($("#ML"+i).html());
							document.getElementById("mlt").innerHTML=mlTotal + "";
							var elTotal = 0;
							var elTable = document.getElementById("ELT1");
							for(var i=1;elTable!=null&&i<=elTable.rows.length-1;i++)elTotal+=parseFloat($("#EL"+i).html());
							document.getElementById("elt").innerHTML=elTotal + "";
							var sclTotal = 0;
							var sclTable = document.getElementById("SCLT1");
							for(var i=1;sclTable!=null&&i<=sclTable.rows.length-1;i++)sclTotal+=parseFloat($("#SCL"+i).html());
							document.getElementById("sclt").innerHTML=sclTotal + "/15";
						}, 1000);
		});	
			//alert(leaveDate);
	});///*/
		

});