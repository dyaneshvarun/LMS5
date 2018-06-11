var leaveType = new Array();
var categories = new Array();

function drawBasicOutput(){
		var table = "<table class='table table-bordered' id='leaveStaffTable'>";
		table+="<tr><th></th>"
		//tableHeader - Categories of Staff
		for(var i=0;i<categories.length;i++)
			table+="<th >"+categories[i]+"</th>";
		table+= "</tr>";
		
		//Table Data - leave Type Selection
		for(var i=0;i<leaveType.length;i++)
		{	
			table += "<tr>";
			table += "<td id='ct'>"+leaveType[i]["DESCRIPTION"]+"</td>";
			for(var j=0;j<categories.length;j++)
				table+="<td>"+"<input type='checkbox' id='cb"+leaveType[i]["TYPE_ID"]+categories[j]+"'>"+"</td>";
			table += "<tr/>"
		}
		
		//Close Table
		table += "</table>"
		
		//Update Button
		table += "<button class='btn btn-success col-lg-12' id='updateButton'>Update</button>";
		$("#output").append(table);
	}
function updateLeaveFromJSON(){
	$.getJSON("staffLeave.json",new Date().getTime(),function(json){
		console.log(json);
		$.each(json,function(i,obj){
			var lt = obj.LEAVE_TYPE;
			for(var j=0;j<obj.STAFF_TYPE.length;j++)
			{	var temp= "#cb"+lt+obj.STAFF_TYPE[j];
				$(temp).prop('checked',true);
			}
		});
	});
}
$(document).ready(function(){
	$.post("qengine.php",{
		op:22,
		attr:"*",
		table:"LEAVE_TYPE"
	},function(data,status){
	   leaveType = $.parseJSON(data);
	   $.post("qengine.php",{
			op:22,
			attr:"DISTINCT(`CATEGORY`)",
			table:"STAFF"
		},function(data,status){
			var res = $.parseJSON(data);
			$.each(res,function(i,obj){
				categories.push(obj.CATEGORY);
			});
			var first = drawBasicOutput();
			var second = updateLeaveFromJSON();
		});
	});
	$("#output").on('click',"#updateButton",function updateButtonClicked(){
		var obj = new Array();
		for(var i=0;i<leaveType.length;i++)
		{	
			var obj1 = new Object();
			obj1.LEAVE_TYPE = leaveType[i]["TYPE_ID"];
			obj1.STAFF_TYPE = new Array();
			for(var j=0;j<categories.length;j++)
			{
				var temp ="#cb"+leaveType[i]["TYPE_ID"]+categories[j];
				if($(temp).prop('checked')==true)
				{
					obj1.STAFF_TYPE.push(categories[j]);
				}
			}
			obj.push(obj1);
		}
		var createdJSON = JSON.stringify(obj);
		$.post("qengine.php",{
			op:15,
			stringToWrite : createdJSON,
			docToWrite : "staffLeave.json"
		},function(data,status){
			alert(data);
		});
	});
});