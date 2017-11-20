$(document).ready(function(){
	
	$("#output").hide();
	$("#submitButton").on('click',function(e){
		var i =0;
		$("#labIncharge").text("");
		for(i=1;i<=5;i++)
		{
			$("#staff"+i).text("");
			$("#delete"+i).hide();
		}
		var labID = $('#labsID').val();
		var classID = $('#classID').val();
		$.get("labs.php",{
			labName : labID,
			className : classID,
			task : 1
		},function(data,status)
		{
			var res = $.parseJSON(data);
			$.each(res,function(i,obj){
				var labIncharge = obj.STAFF_NAME;
				$("#labIncharge").text(labIncharge);
			});
			//$("#output").show();
		});
		$.get("labs.php",{
			labName : labID,
			className : classID,
			task : 2
		},function(data,status)
		{
			var res1 = $.parseJSON(data);
			$.each(res1,function(i,obj){
				var labIncharge = obj.STAFF_NAME;
				var j = i+1;
				var index = "#staff"+j;
				$(index).text(labIncharge);
				$("#delete"+j).val(obj.STAFF_ID);
				$("#delete"+j).show();
			});
			$("#output").show();
		});
		$.get("labs.php",{
			labName : labID,
			className : classID,
			task : 5
		},function(data,status)
		{
			var res2 = $.parseJSON(data);
			$.each(res2,function(i,obj)
			{
				$('#sp').val(obj.H1);
				$('#ep').val(obj.H2);
				$('#courseI').val(obj.PAPER_ID);
				$('#classI').val(obj.CLASS_ID);
				$('#dayI').val(obj.DAY_ID);
			});
		});
	});
	$(".deleteB").on('click',function(e){
		var labID = $('#labsID').val();
		var classID = $('#classID').val();
		var staffID = this.value;
		$.get("labs.php",{
			labName : labID,
			className : classID,
			staffName : staffID,
			task : 3
		},function(data,status)
		{
			$('#submitButton').trigger('click');
			$("#output").show();
		});
	});
	$("#AddButton").on('click',function(e){
		var sp = $('#sp').val();
		var ep = $('#ep').val();
		var staff = $('#staffI').val();
		var course =  $('#courseI').val();
		var class1 = $('#classI').val();
		var day = $('#dayI').val();
		if(ep-sp+1>8)alert("Period List is too high");
		else{
				$.get("labs.php",{
					start : sp,
					end :ep,
					staffName : staff,
					courseName : course,
					dayName : day,
					className :class1,
					task : 4
				},function(data,status)
				{
					$("#output").hide();
					//$('#labsID').val(course);
					//$('#classID').val(class1);
					$('#submitButton').trigger('click');
					//$("#output").show();
				});
		}
	});
});