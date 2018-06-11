$(document).ready(function(){
	var allstaffID = [];
	var allstaffName = [];
	var allclassID = [];
	var allclassName = [];
	// $('#myTable').DataTable();
	$.post("qengine.php",
			{
				op :22,
				table : 'staff',
				attr :'STAFF_ID,STAFF_NAME'
			},function(data,status){
				var res = $.parseJSON(data);
				$.each(res,function(i,obj){
					allstaffID.push(obj.STAFF_ID);
					allstaffName.push(obj.STAFF_NAME);
				});
				$(".staName").each(function()
				{
					var j = ($(this).html());
					var i = allstaffID.indexOf(j);
					$(this).html(allstaffName[i]);
				});
			});
			
	$.post("qengine.php",
			{
				op :22,
				table : 'class',
				attr : 'CLASS_ID,CLASS_NAME'
			},function(data,status){
				var res = $.parseJSON(data);
				$.each(res,function(i,obj){
					allclassID.push(obj.CLASS_ID);
					allclassName.push(obj.CLASS_NAME);
				});
				$(".claName").each(function()
				{
					var j = ($(this).html());
					var i = allclassID.indexOf(j);
					$(this).html(allclassName[i]);
				});
			});
			
});