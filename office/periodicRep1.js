
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
		 var req = new XMLHttpRequest();
		 var params = "fro="+leaveDate[0]+"&to="+leaveDate[1];
		  req.open("POST", "generatePDF.php", true);
		   req.responseType = "blob";
		  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		 
		   
		  req.onreadystatechange = function() {//Call a function when the state changes.
				if(req.readyState == 4 && req.status == 200) {
					req.onload = function (event) {
					var blob = req.response;
					console.log(blob.size);
					var link=document.createElement('a');
					link.href=window.URL.createObjectURL(blob);
					link.download="LeaveReport.pdf";
					link.click();
				  };
				}
			}
			req.send(params);
		 
});
});