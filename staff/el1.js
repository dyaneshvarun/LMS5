var opterr = 1,noderr = 1,d1err =1, d2err =1, reserr=1;
var apperr = "<span class='glyphicon glyphicon-remove form-control-feedback'></span><span class='help-block'>";
var pherr=0,phArray = new Array(),allstaffID= new Array(),allstaffName = new Array();
function dispErr(tag,msg){
	$(tag).closest("div").addClass("has-error").addClass("has-feedback");
	$(tag).closest("div").find('span').remove();
	$(tag).closest("div").append(apperr + msg + "</span>");
}
function clearErr(tag){
	$(tag).closest("div").removeClass("has-error").removeClass("has-feedback");
	$(tag).closest("div").find('span').remove();
}
var today = new Date();

$(document).ready(function(){
	$body = $("body");
	// Get the modal
	var modal = document.getElementById('modal');
	$.get("getPH.php",
			{},function(data,status){
				var res = $.parseJSON(data);
				$.each(res,function(i,obj){
					var rhDate =obj.HOLIDAY_DATE;
					var date1 = new Date(obj.HOLIDAY_DATE);
					var parseDate =  $.datepicker.formatDate("mm/dd/yy",date1);
					phArray.push(parseDate);
					
					
				});
			});
	$.post("qengine.php",
			{
				op :8
			},function(data,status){
				var res = $.parseJSON(data);
				$.each(res,function(i,obj){
					allstaffID.push(obj.ID);
					allstaffName.push(obj.SN);
				});
			});
	var staffmail ;
	$.post("qengine.php",
			{
				op :10
			},function(data,status){
				var res = $.parseJSON(data);
				staffmail= res[0].EMAILID;
			});
	
		var opt = $("#lt").val();
		if(opt == 'none'){
			opterr = 1;
			dispErr('#lt',"Please Select a Valid Leave Type");
			$("#date1").prop('disabled',true);
			$("#date2").prop('disabled',true);
			$("#res").prop('disabled',true);
			$("#addr").prop('disabled',true);
		}
		else{
			opterr = 0;
			clearErr("#lt");
			var sta_id = $("#sid").val();
			$.post("qengine.php",
			{
				op:1,
				type: opt
			},function(data,status){
				//alert(data);
				var res = $.parseJSON(data);
				
				$("#bal").val(res['total'] - res['avail']);
				$("#tot").val(res['avail']);
				$("#nod").prop('disabled',false);
				$("#date1").prop('disabled',false);
				//$("#date2").prop('disabled',false);
				$("#res").prop('disabled',false);
				$("#addr").prop('disabled',false);
			});
		}
	
	$("#date1,#date2").focusin(function(){
		
		$(this).datepicker(
			{dateFormat: 'dd/mm/yy',  changeMonth: true, changeYear: true, yearRange: '2016:2017'}
		);
	});
	$("#nod").change(function(){
		var nod = $("#nod").val();
		$("#date1,#date2").val("");
		if(nod >= 1 ){
			noderr = 0;	
			$("#date1").prop('disabled',false);
			$("#res").prop('disabled',false);
			$("#addr").prop('disabled',false);
			clearErr("#nod");
		}
		else{
			$("#date1").prop('disabled',true);
			$("#date2").prop('disabled',true);	
		}
		
	});
	$("#date1,#vacation").change(function(){
		$("body").addClass("loading");
		modal.style.display = "block";
		setTimeout(function(){
		var date1 = new Date($('#date1').datepicker('getDate'));
		var vacationChecked = $("#vacation").prop("checked");
		//changed code
		var fromdate = $('#date1').datepicker('getDate');
		var today = new Date();
		if(today>fromdate)
			alert("You are selecting the date that is prior to Todays'Date");
		//changed code
		$("#altertitle1").empty();
		var temp = date1;
		var count=$("#nod").val();
		var t1 = 0;
		while(t1 < count){
			$("body").addClass("loading"); 
			var day = temp.getDay();
			var checkPHDate = $.datepicker.formatDate("mm/dd/yy",temp);
			pherr = phArray.includes(checkPHDate);
			if(day!=0 && day!=6  && pherr==false ){
				var showDate = $.datepicker.formatDate("dd/mm/yy",temp);
				var dbDate = $.datepicker.formatDate("yy--mm-dd",temp);
if(count <4)
{
				var insr = "<center><h3>Duty Alteration</h3></center><div class='form-group' class='altrem' id='dutyalter11'><label class='control-label col-sm-3' for='nod'>" + showDate + "</label><div class='col-sm-9'><table class='table table-bordered tt' id='tableD" + t1 + "'><tr><th>Date</th><th>Class</th><th>Hour</th><th>Alternatives</th><th>Others</th></tr></table></div></div>";
				$("#altertitle1").append(insr);
}
				t1++;
			}
			if(t1==count){
				var d2date = $.datepicker.formatDate("dd/mm/yy",temp);
				$("#date2").val(""+d2date);
				break;
			}
			temp.setDate(temp.getDate() + 1);
		}
		t1 = 0;
		var date1 = new Date($('#date1').datepicker('getDate'));
		var temp = date1;
		var countAlter = 0;
		if(vacationChecked==true)
		{
			alert("This is to confirm that you have checked the VACATION check box and you are in Vacation Period");
		}
		while(t1 < count && vacationChecked==false){
			$("body").addClass("loading"); 
			var dbDate = $.datepicker.formatDate("yy-mm-dd",temp);
			var day = temp.getDay();
			var checkPHDate = $.datepicker.formatDate("mm/dd/yy",temp);
			pherr = phArray.includes(checkPHDate);
			if(day!=0 && day!=6  && pherr==false ){
				$.ajax({
					type: 'POST',
					url: "qengine.php",
					data : {op:6,did:day},
					async : false,
					success: function(result){
						var data1 = $.parseJSON(result);
						$.each(data1,function(i,obj){
							t2 = t1;
							var tablen = "#tableD" + t2;
							var ins = "<tr id='inrow'><td class='col-xs-3'>";
							ins += "<input class='form-control' type='text' id='datee' value='"+ dbDate + "' disabled></input></td>";
							ins += "<td class='col-sm-2'><input type='text' class='form-control' id='class1' value='" + obj.CLASS_ID + "' disabled ></td>";
							ins += "<td class='col-sm-1'><input type='text' class='form-control' id='hr' value='" + obj.HOUR + "' disabled ></td>";
							ins += "<td><select class='form-control' id='alterstaff'>";
							$.ajax({
								type: 'POST',
								url: 'qengine.php',
								data: {op:5,dol:dbDate,hr:obj.HOUR,did:day},
								async: false,
								success: function(result1){
									var data2 = $.parseJSON(result1);
									ins += "<option value=''>---</option>";
									$.each(data2,function(j,obj1){
										ins += "<option value='"+obj1.STAFF_ID + "'>" + obj1.STAFF_NAME + "</option>";
									});
							}});
							ins += "</select></td>";
							ins += "<td><select class='form-control' id='alterstaff1'>";
							ins += "<option value=''>---</option>";
							$.each(allstaffID,function(j){
								ins += "<option value='"+allstaffID[j]+ "'>" + allstaffName[j] + "</option>";
							});
							ins += "</td></tr>";
							$(tablen).append(ins);
							countAlter++;
						});
				}});
				$(this).delay(1000);
				$("body").removeClass("loading");	
				t1++;
			}
			if(t1==count){
				break;
			}
			temp.setDate(temp.getDate() + 1);
		}
		$body.removeClass("loading"); 
		modal.style.display = "none";
		},500);
		
	
	});
	$("#date1").change(function(){
		var td1 = $("#date1").val();
		if(td1 == ''){
			d1err = 1;
			dispErr("#date1","Enter Select a Valid Date");
		}
		else{
			d1err = 0; clearErr("#date1");
		}
	});
	$("#date2").change(function(){
		var td2 = $("#date2").val();
		if(td2 == ''){
			d2err = 1;
			dispErr("#date2","Enter Select a Valid Date");
		}
		else{
			d2err = 0; clearErr("#date2");
		}
	});
	$("#res").focusout(function(){
		var reso = $("#res").val();
		if(reso == ''){
			reserr = 1;
			dispErr("#res","Reason Field Empty");
		}
		else{
			reserr = 0;
			clearErr("#res");
		}
	});
	$("#fsub").submit(function(e){
		e.preventDefault();
		$body.addClass("loading");
		modal.style.display ="block";		
		setTimeout(function(){
		var td1 = $("#date1").val();
		if(td1 == ''){
			d1err = 1;
			dispErr("#date1","Enter Select a Valid Date");
		}
		else{
			d1err = 0; clearErr("#date1");
		}
		var nod = $("#nod").val();
		if(nod > 0){
			var noderr = 0;
		}
		else{
			var noderr = 1;
		}
		var td2 = $("#date2").val();
		if(td2 == ''){
			d2err = 1;
			dispErr("#date2","Enter Select a Valid Date");
		}
		else{
			d2err = 0; clearErr("#date2");
		}
		var staffErr =0;
		var row = $(this).find("td");
		$(".tt #inrow").each(function(){
				var row123 = $(this).find("td");
				var alter123 = row123.find("#alterstaff").val();
				if (alter123 == '')
					alter123 = row123.find("#alterstaff1").val();	
				if (alter123 == '') staffErr = 1;
			});
		if(opterr == 0 && noderr == 0 && reserr == 0 && d1err == 0 &&staffErr==0){
			var alterArray = new Array();
			var alternateMail =new Array();
			$(".tt #inrow").each(function(){
				var row = $(this).find("td");
				var value = row.find("#datee").val();
				var hr = row.find("#hr").val();
				var cid = row.find("#class1").val();
				var alter = row.find("#alterstaff").val();
				if (alter == '')
					alter = row.find("#alterstaff1").val();	
				var eachAlter = {year:value, hour:hr, alterstaff:alter,class:cid};
				alterArray.push(eachAlter);
				
				alternateMail.push(alter);
			});
			var alterName = new Array();
			var alterEmail = new Array();
			$.post("qengine.php",{
						op : 11,
						alternateStaff : alternateMail
					},function(data,status){
						var res = $.parseJSON(data);
						$.each(res,function(i,obj){
							alterName.push(obj.STAFF_NAME);
							alterEmail.push(obj.EMAILID);
						});
			});;
			
			var ltype = $("#lt").val();
			var fdate = $("#date1").val();
			var temp = $.datepicker.parseDate("dd/mm/yy",fdate);
			fdate = $.datepicker.formatDate("yy-mm-dd",temp);
			var tdate = $("#date2").val();
			temp = $.datepicker.parseDate("dd/mm/yy",tdate);
			tdate = $.datepicker.formatDate("yy-mm-dd",temp);
			var res = $("#res").val();
			var addr = $("#addr").val();
			var HODContent = $("#name").val() + "  has applied "+ ltype +"(Leave Type) leave for "+$("#nod").val() +"day(s) from "+fdate+" to "+tdate +". Applied Date : "+today+"  Kindly review the Awaiting List ."
			var StaffContent = " You have applied "+ ltype +"(Leave Type) leave for "+$("#nod").val() +"day(s) from "+fdate+" to "+tdate +". "
			$.post("qengine.php",{
				op:2,
				alterData:alterArray,
				lt:ltype,
				fd:fdate,
				td:tdate,
				re:res,
				ad:addr
			},function(data,status){
				alert(data);
				if(data == 1){
					var today = new Date();
					var StaffContent = " Leave Type : <b> "+ ltype.toUpperCase() +"</b>(Leave Type) <br/>Number of Days :<b>"+$("#nod").val() +"day(s)</b><br/>From Date:<b> "+fdate+" </b><br/>To date:<b> "+tdate +"</b><br/>Applied date : <b>"+today+"</b>";
					$.post("../testMail.php",{
						content : StaffContent ,
						subject : "Applied Successfully ! Leave EL " ,
						toEmail : staffmail,
						toName  : $("#name").val()  //Name of the corresponding Email
					},function(data,status){
		
					});;
					for(var j =0; j < alternateMail.length;j++)
					{
						var alterSubject = 'Alteration Provided by '+$("#name").val();
						var alterContent = 'You have been given alteration on '+alterArray[j]['year'] + ' by ' + $("#name").val() + ' for class '+ alterArray[j]['class'] +' during hour '+alterArray[j]['hour'];
						$.post("../testMail.php",{
						content : alterContent ,
						subject : alterSubject,
						toEmail : alterEmail[j] ,
						toName  : alterName[j] 
						
						},function(data,status){
						});;
					}

					
					alert("Leave Requested Successfully");
					$body.removeClass("loading");
					modal.style.display = "none";
					window.location.replace("index.php");
					window.open("table-withoutdays.php");
				}
				if(data == 2){
					var today = new Date();
					var StaffContent = " Leave Type : <b> "+ ltype.toUpperCase() +"</b>(Leave Type) <br/>Number of Days :<b>"+$("#nod").val() +"day(s)</b><br/>From Date:<b> "+fdate+" </b><br/>To date:<b> "+tdate +"</b><br/>Applied date : <b>"+today+"</b>";
					var recentlid ;
					//Get recent Leave ID
					$.post("qengine.php",{
								op:21,
								lt:ltype
							},function(data,status){
								var res = $.parseJSON(data);
								$.each(res,function(i,obj){
									recentlid = obj.LEAVE_ID;
								});
					});
					setTimeout(function(){
						var HODContent = "Leave Applied by <b>"+ $("#name").val()+ " from "+ fdate +" to "+ tdate+ "</b> <br/>Leave ID :  <b>"+recentlid+" </b> <br/>Number of Days :  <b>"+$("#nod").val()+"</b><br/>Leave Type :  "+ltype+"</b><br/>Kindly review the leave at Website";
						$.post("../testMail.php",{
							content : HODContent ,
							subject : "Review Leave #"+recentlid,
							toEmail : "hod@auist.net", //HOD Mail ID
							toName  : "HOD_IST"  //Name of the corresponding Email
						},function(data,status){
							//alert(data);
						});;
					},2000);
					$.post("../testMail.php",{
						content : StaffContent ,
						subject : "Applied Successfully ! Leave " + ltype.toUpperCase(),
						toEmail : staffmail,
						toName  : $("#name").val()  //Name of the corresponding Email
					},function(data,status){
		
					});;
					
					alert("Leave Requested Successfully");
					$body.removeClass("loading");
					modal.style.display = "none";
					window.location.replace("index.php");
					window.open("table-withoutdays.php");
				}
				else if(data!=1 && data!=2)
				{
					$body.removeClass("loading");
					modal.style.display = "none";
				}
			});
			
		}
		else{
			if(noderr == 1) alert("Enter a valid number in Number of days field");
			else if(reserr == 1) alert("Enter a valid reason");
			else if(staffErr == 1) alert("Add an alternating staff");
			else if(d1err==1) alert("Enter a valid date");
			//alert("Form Not Valid " + opterr + noderr + reserr + d1err + staffErr);
			$body.removeClass("loading");
			modal.style.display = "none";
		}
		},1000);	
	});
});

