$(document).ready(function(){
	$("#fsub").submit(function(e){
		var aleaveIds =  new Array();
		var dleaveIds =  new Array();
		var acceptAlterArray = new Array();
		var declineAlterArray =  new Array();
		var acceptLeaveIds = new Array();
		//var leaveIds = [];
		e.preventDefault();
		$(".tt #inrow").each(function(){
			var row = $(this).find("td");
			JSON.stringify(row);
			var opt = row.find("#opt").val();
			if(opt != "none"){
				var lid = row.find("#lid").val();
				
				var clid = row.find("#clid").val();
				var adate = row.find("#adate").val();
				var hr = row.find("#hr").val();
				var eachAlter = {clsid:clid, alt_date: adate, hour: hr, opts : opt};
				if(opt=="ACCEPT")
				{
					acceptAlterArray.push(eachAlter);
					aleaveIds.push(lid);
				}
				else {
					declineAlterArray.push(eachAlter);
					dleaveIds.push(lid);
				}
			}
		});	
		console.log(dleaveIds);
		if(acceptAlterArray.length > 0){
			$.post("qengine.php",
			{
				op: 7,
				data: acceptAlterArray,
				leaveId: aleaveIds
			},function(data,status){
				alert(data);
			});
			console.log("AAA");console.log(acceptAlterArray);
		}
		if(declineAlterArray.length > 0){
			$.post("qengine.php",
			{
				op: 7,
				data: declineAlterArray,
				leaveId: dleaveIds
			},function(data,status){
				alert(data);	
			});
			console.log("DAA");console.log(declineAlterArray);
		}
		$.post("qengine.php",
		{
			op: 15,
			data: acceptAlterArray,
			leaveId: aleaveIds
		},function(data,status){
			if($.trim(data)){
				var response = $.parseJSON(data);
				var j =0;
				$.each(response,function(i,obj){
					if(acceptLeaveIds.includes(obj.LEAVE_ID)==false)
					{
						acceptLeaveIds.push(obj.LEAVE_ID);
						j++;	
					}
					});
				
				
				//alert("PHP OUTPUT"+status);*/
				//console.log("DATA");console.log(response);
				//console.log(acceptLeaveIds);
				for(var k=0;k<j;k++){
				$.ajax({
					type : 'POST', 
					url  : "sendMailToHOD.php", 
					async : true,
					data : {	lid : acceptLeaveIds[k]
							},
					dataType : 'text',
					success :  function(data) {
						//alert("Final"+acceptLeaveIds[0]);
						console.log("MAIL");console.log(data);
						//alert("MAIL DONE");
						
					} 
				  }); 
				}
				 }
		});
		window.location.reload();
	});
});
