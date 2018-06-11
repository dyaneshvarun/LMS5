//Loading Class and Staff Names
var classnames = [];
var staffname = [];
var staffid = [];
var statusName =["Waiting","Accepted","Declined"]
var statusColors = ["warning","success","danger"]
	
$.post("qengine.php",{
			op:22,
			attr: "CLASS_ID,CLASS_NAME",
			table: "CLASS"
		},function(data,status){
			var res = $.parseJSON(data);
			$.each(res,function(i,obj){
				classnames[obj.CLASS_ID]=obj.CLASS_NAME;
			});
});
//ClassNames Loaded
function getData(lid){
	$.post("qengine.php",{
		op:22,
		attr: "APPLY_DATE,FILENAME,REASON,ADDRESS",
		table: "STAFF_LEAVE where LEAVE_ID = "+lid+""
	},function(data,status){
		//console.log(data);
		var res = $.parseJSON(data);
		$("#mad").empty();$("#mad").append(res[0].APPLY_DATE);
		$("#mfile").empty();if(res[0].FILENAME !=null){$("#mfile").append("<a target='_blank' href='../staff/uploads/"+res[0].FILENAME+"'> File </a>");}
		$("#mreason").empty();$("#mreason").append(res[0].REASON);
		$("#maddress").empty();$("#maddress").append(res[0].ADDRESS);
		
		//Reschedule table
		var restab = "<table class='table table-hover' >";
		restab += "<tr> <th>Date</th>\
						<th>Hour</th>\
						<th>Class</th>\
						<th>Staff Name</th>\
						<th>Status</th>\
						<th>Postponed Date & Hour *</th></tr>";
		$.post("qengine.php",{
			op:22,
			attr: "*",
			table: "STAFF_PERIOD_ALLOCATION WHERE LEAVE_ID IN (SELECT SLDID FROM `STAFF_LEAVE_DAYS` WHERE LEAVE_ID = "+lid+")"
		},function(data,status){
			if(data!="[]"){
				var res = $.parseJSON(data);
				$.each(res,function(i,obj){
					if(obj.PDATE!=null)
						restab += "<tr class='info'>";
					else
						restab += "<tr class ='"+statusColors[obj.STATUS]+"'>";
					var alterDate = new Date(obj.ALTER_DATE);
					restab += "<td>"+alterDate.getDate()+"/"+(alterDate.getMonth()+1)+"/"+alterDate.getFullYear()+"</td>";
					restab += "<td>"+obj.HOUR+"</td>";
					restab += "<td>"+classnames[obj.CLASS_ID]+"</td>";
					restab += "<td>"+staffname[staffid.indexOf(obj.ALTER_STAFF_ID)]+"</td>";
					if(obj.PDATE!=null)
					{
						restab += "<td>Postponed</td><td>"+obj.PDATE+" & "+obj.PHR+" hr</td></tr>";
					}	
					else 
						restab += "<td>"+statusName[obj.STATUS]+"</td><td></td></tr>";	
				});
				restab += "</table>";
				$("#reschedule").empty();
				$("#reschedule").append(restab);
			}
			else 
			{
				$("#reschedule").empty();
				$("#reschedule").append("<center><b>No rescheduled Classes</b></center>");
			}
		});
		
		//Reschedule table ends
		
		//Show the modal
		$("#exampleModalLong").modal("show");
	});
}
$(document).ready(function(){
	var categ = [];
	$.post("qengine.php",{
		op:22,
		attr: "STAFF_ID , CATEGORY , STAFF_NAME",
		table: "STAFF"
	},function(data,status){
		var res = $.parseJSON(data);
		$.each(res,function(i,obj){
			staffid.push(obj.STAFF_ID);
			staffname.push(obj.STAFF_NAME);
			categ.push(obj.CATEGORY);
		});
		$('.leaves').each(function(){
			var replaceText = categ[staffid.indexOf($(this).find("#sid").html())];
			$(this).find("#sid").html(replaceText);
		});
	});
	
	$("#fsub").submit(function(e){
		e.preventDefault();
		addLoadingClass();
		
		var total = $(".leaves").length;
		console.log(total);
		var j =0;
		var numstats = new Array();
		var leaves = new Array();
		$('.leaves').each(function(){
			var thisVar = $(this);
			if(thisVar.css('display')!="none"){
				var lid = parseInt($(this).find(".lid").html());
				var stat = $(this).find("input[id="+lid+"]:checked").val();
				if(stat != 'N'){
					if(stat == 'ACCEPT'){
						var numstat = 1;
					}
					else if(stat == 'REJECT')
						var numstat = 2;
					leaves.push(lid);
					numstats.push(numstat);
					$.post("qengine.php",{
						op:"1",
						lid:lid,
						lstat:numstat
					},function(data,status){
						
							if(numstats[j]==1){
								$.ajax({
										url: "qengine.php",
										method : "POST",
										async: false,
										data:{
												op:"12",
												lid:leaves[j]	
											 }
								}).done(function(data,status){
									//alert(data);
									j++;
								});
							}
							else if(numstats[j]==2){
								$.ajax({
										url: "qengine.php",
										method : "POST",
										async: false,
										data:{
												op:"13",
												lid:leaves[j]	
											 }
								}).done(function(data,status){
									//alert(data);
									j++;
								});
								
							}
							if(j==total)
							{	window.location.replace("awaiting_response1.php");
								removeLoadingClass();
								console.log(numstats.length);
							}
						
					});
				}
			}
		});
		if(numstats.length == 0) removeLoadingClass();
		
	});
	$("#caarb").on('click',function(){
		$('.leaves').each(function(){
			var thisVar = $(this);
			if(thisVar.css('display')!="none"){
				$(this).find("#r").find(".leavestat").removeAttr('checked');
				$(this).find("#a").find(".leavestat").prop('checked','true');
			}
		});
	});
	$("#carrb").on('click',function(){
		$('.leaves').each(function(){
			var thisVar = $(this);
			if(thisVar.css('display')!="none"){
				$(this).find("#a").find(".leavestat").removeAttr('checked');
				$(this).find("#r").find(".leavestat").prop('checked','true');
			}
		});
	});
	$("#buttonT").on('click',function(){
		$("#buttonRS").removeClass('btn-success');$("#buttonRS").addClass('btn-info');
		$("#buttonNT").removeClass('btn-success');$("#buttonNT").addClass('btn-info');
		$("#buttonAll").trigger('click');
		$("#buttonAll").removeClass('btn-success');$("#buttonAll").addClass('btn-info');
		$(this).removeClass('btn-info');
		$(this).addClass('btn-success');
		$('.leaves').each(function(){
			if($(this).find("#sid").html()!="RT" && $(this).find("#sid").html()!="TF")
				$(this).hide();
		});
	});
	$("#buttonNT").on('click',function(){
		$("#buttonRS").removeClass('btn-success');$("#buttonRS").addClass('btn-info');
		$("#buttonT").removeClass('btn-success');$("#buttonT").addClass('btn-info');
		$("#buttonAll").trigger('click');
		$("#buttonAll").removeClass('btn-success');$("#buttonAll").addClass('btn-info');
		$(this).removeClass('btn-info');
		$(this).addClass('btn-success');
		$('.leaves').each(function(){
			if($(this).find("#sid").html()!="RNT")
				$(this).hide();
		});
	});
	$("#buttonRS").on('click',function(){
		$("#buttonNT").removeClass('btn-success');$("#buttonNT").addClass('btn-info');
		$("#buttonT").removeClass('btn-success');$("#buttonT").addClass('btn-info');
		$("#buttonAll").trigger('click');
		$(this).removeClass('btn-info');
		$(this).addClass('btn-success');
		$("#buttonAll").removeClass('btn-success');$("#buttonAll").addClass('btn-info');
		$('.leaves').each(function(){
			var tempVal = $(this).find("#sid").html();
			if(tempVal!="RSO" && tempVal!="RS20" && tempVal!="RS30") // Changes to RS20 and RS30
				$(this).hide();
		});
	});
	$("#buttonAll").on('click',function(){
		$(this).removeClass('btn-info');
		$(this).addClass('btn-success');
		$("#buttonNT").removeClass('btn-success');$("#buttonNT").addClass('btn-info');
		$("#buttonT").removeClass('btn-success');$("#buttonT").addClass('btn-info');
		$("#buttonRS").removeClass('btn-success');$("#buttonRS").addClass('btn-info');
		$('.leaves').each(function(){
				$(this).show();
		});
	});
});
