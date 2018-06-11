$(document).ready(function(){
	$("#fsub").submit(function(e){
		e.preventDefault();
		var lid = $("#lid").val();
		$.post("qengine.php",{
					op:"1",
					lid:lid,
					lstat:4
				},function(data,status){
					if(data==1)alert("Leave Cancelled Successfully");
					else alert(data);
					window.location.replace("cancelRequest.php");
				});
	});
});
