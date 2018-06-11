$(document).ready(function(){
	$("#output").hide();
	$("#submitButton").on('click',function(e){
		var classID = $('#classID').val();
		$.get("timetable1.php",{
			className : classID,
			task : 1
		},function(data,status)
		{
			var res = $.parseJSON(data);
			var staff = new Array(5);
			var subject = new Array(5);
			for (var i = 0; i < 5; i++) {
			  subject[i] = new Array(8);
			  staff[i] = new Array(8);
			  for (var j = 0; j < 8; j++) {
				subject[i][j] = 0;
				staff[i][j] = 0;
				var staffName = "#staff"+(i+1)+(j+1);
				$(staffName).text("");
			  }
			}
			
			$.each(res,function(i,obj){
				var day =obj.DAY;
				var hour = obj.HOUR;
				var paper = obj.PAPER;
				subject[day-1][hour-1] = paper;
				var staff1 = obj.STAFF;	
				staff[day-1][hour-1] = staff1;
				var staffName = "#staff"+(day)+(hour);
				$(staffName).text(staff1+"-"+paper);
			});
			console.log(staff);
			$("#output").show();
		});
		
	});
	$("#deleteButton").on('click',function(e){
		var classID = $('#classID').val();
		$.get("timetable1.php",{
			className : classID,
			task : 2
		},function(data,status)
		{
			console.log(data);
		});
		
	});
	$("#updateButton").on('click',function(e){
		var classID = $('#UclassID').val();
		var staffID = $('#UstaffID').val();
		var period = $('#Uperiod').val();
		var day = $('#UdayID').val();
		var paper = $('#UpaperID').val();
		//alert(classID+staffID+period+day+paper);
		if (classID=="none" || day=="none" || period=="none")alert("Invalid Input");
		else if(paper=="none" || staff=="none" ||staff==""||paper==""){
			alert("Deleting...");
			$.get("timetable1.php",{
			className : classID,
			periodName : period,
			dayName : day,
			task : 3
		},function(data,status)
		{
			//console.log(data);
		});
		}
		else{
			alert("Updated");
			$.get("timetable1.php",{
			className : classID,
			staffName : staffID,
			periodName : period,
			dayName : day,
			paperName : paper,
			task : 4
		},function(data,status)
		{
			//console.log(data);
		});
		}
		
	});
});