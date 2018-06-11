$(document).ready(function(){
	var staffTypes = new Array();
	$.getJSON("../admin/staffLeave.json",new Date().getTime(),function(json){
		console.log(json);
		console.log($("#lt").val());
		$.each(json,function(i,obj){
			if(obj.LEAVE_TYPE.toLowerCase() == $("#lt").val().toLowerCase()){
				staffTypes = obj.STAFF_TYPE;
			}
		});
		console.log(window.location.pathname.split( '/' )[3]);
		//console.log($("#sid").val());
		$.post("qengine.php",{
			op:22,
			attr : "CATEGORY",
			table : "STAFF WHERE STAFF_ID = "+parseInt($("#sid").val())
		},function(data,status){
			var val = $.parseJSON(data);
			var staffCat = (val[0]["CATEGORY"]);
			var leaveType =$("#lt").val();
			if(window.location.pathname.split( '/' )[3] == "hcl.php")
			{
				console.log("HALF DAY CL");
				if(staffCat=="RS30") $("#lt1").val("cl30");
				else if(staffCat=="RS20") $("#lt1").val("cl20");
				else if(staffCat=="RSO") $("#lt1").val("cl30");
				else if(staffCat=="TF") $("#lt1").val("cl6");
				$("#lt1").change();
			}
			else if(!staffTypes.includes(staffCat)) {
				if(leaveType[0]=='c' && leaveType[1]=='l') 
				{
					console.log("Casual Leave type");
					if(staffCat=="RT") window.location = "cl.php";
					else if(staffCat=="RNT") window.location = "cl.php";
					else if(staffCat=="TF") window.location = "cl6.php";
					else if(staffCat=="RS20") window.location = "cl20.php";
					else if(staffCat=="RS30") window.location = "cl30.php";
					else if(staffCat=="RSO") window.location = "cl30.php";
				}	
				else{
					alert("You are not allowed to take this type of Leave. Redirecting..");
					window.location = "index.php";
				}
			}
		});
	});

});