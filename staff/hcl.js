var opterr = 0,noderr = 1,d1err =1, d2err =1, reserr=1;
var allstaffID= new Array(),allstaffName = new Array();
var apperr = "<span class='glyphicon glyphicon-remove form-control-feedback'></span><span class='help-block'>";

function dispErr(tag,msg){
	$(tag).closest("div").addClass("has-error").addClass("has-feedback");
	$(tag).closest("div").find('span').remove();
	$(tag).closest("div").append(apperr + msg + "</span>");
}
function clearErr(tag){
	$(tag).closest("div").removeClass("has-error").removeClass("has-feedback");
	$(tag).closest("div").find('span').remove();
}
var date1,parseDate;var alterArray = new Array();
$body = $("body");


	$(document).ready(function(){
	// Get the modal
	var modal = document.getElementById('modal');
	//$("#head1").hide();	
	var opt = $("#lt").val();
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
				//alert(data);
				var res = $.parseJSON(data);
				staffmail= res[0].EMAILID;
			});
	$("#date1,#date2").focusin(function(){
		$(this).datepicker(
			{dateFormat: 'dd/mm/yy',  changeMonth: true, changeYear: true, yearRange: '2016:2017'}
		);
	});
	$("#nod").change(function(){
		var nod = $("#nod").val();
		var balance = $("#bal").val();
		$("#date1,#date2").val("");
		if(nod >= 1 && nod<=balance ){
			noderr = 0;	
			$("#date1").prop('disabled',false);
			clearErr("#nod");
		}
		else{
			$("#date1").prop('disabled',true);
			$("#date2").prop('disabled',true);	
		}
		if(nod>balance)
		{
			dispErr("#nod","Enter valid number of days");
			alert("Enter valid number of days");
		}
	});
	$("#date1,#vacation").change(function(){
		$("body").addClass("loading");
		modal.style.display = "block";
		setTimeout(function(){
			$('#session').prop('disabled',true);
		var date1 = new Date($('#date1').datepicker('getDate'));
		var vacationChecked = $("#vacation").prop("checked");
		$("#altertitle1").empty();
		var temp = date1;
		var session=$("#session").val();
		//alert(session);
		var t1 = 0;
		date1 = new Date($('#date1').datepicker('getDate'));
		temp = date1;
		var countAlter = 0;
		var insr = "<div class='form-group' class='altrem' id='dutyalter11'><h3> <center> Duty Alteration <center></h3><br/><label class='control-label col-sm-3' for='nod'></label><div class='col-sm-9'><table class='table table-bordered tt' id='tableD" + t1 + "'><tr><th>Date</th><th>Class</th><th>Hour</th><th>Alternatives</th><th>Others</th></tr></table></div></div>";
		//" + showDate + "
		$("#altertitle1").append(insr);
		if(vacationChecked==true)
		{
			alert("This is to confirm that you have checked the VACATION check box and you are in Vacation Period");
		}
		if(vacationChecked==false){
			$("body").addClass("loading"); 
			var dbDate = $.datepicker.formatDate("yy-mm-dd",temp);
			var day = temp.getDay();
			if(day!=0 && day!=6  ){
				$.ajax({
					type: 'POST',
					url: "qengine.php",
					data : {op:12,did:day,ses:session},
					async : false,
					success: function(result){
						//alert(day);
						//alert(result);
						var data1 = $.parseJSON(result);
						$.each(data1,function(i,obj){
							t2 = t1;
							var tablen = "#tableD" + t2;
							//alert(tablen + " " + i);
							var ins = "<tr id='inrow'><td class='col-xs-3'>";
							ins += "<input class='form-control' type='text' id='datee' value='"+ dbDate + "' disabled></input></td>";
							ins += "<td class='col-sm-2'><input type='text' class='form-control' id='class1' value='" + obj.CLASS_ID + "' disabled ></td>";
							ins += "<td class='col-sm-1'><input type='text' class='form-control' id='hr' value='" + obj.HOUR + "' disabled ></td>";
							ins += "<td><select class='form-control' id='alterstaff'>";
							//$(tablen).append(ins);
								$.ajax({
									type: 'POST',
									url: 'qengine.php',
									data: {op:5,dol:dbDate,hr:obj.HOUR,did:day},
									async: false,
									success: function(result1){
										var data2 = $.parseJSON(result1);
										//alert(data2);
										ins += "<option value=''>---</option>";
										$.each(data2,function(j,obj1){
											ins += "<option value='"+obj1.STAFF_ID + "'>" + obj1.STAFF_NAME + "</option>";
											//$(tablen).append(ins);
										});
								}});
							ins += "</select></td>";
							ins += "<td><select class='form-control' id='alterstaff1'>";
							ins += "<option value=''>---</option>";
							$.each(allstaffID,function(j){
								ins += "<option value='"+allstaffID[j]+ "'>" + allstaffName[j] + "</option>";
							});
							ins += "</td></tr>";
							//$("#head1").show();	
							$(tablen).append(ins);
							countAlter++;
						});
				}});
				$(this).delay(1000);
				$("body").removeClass("loading");	
				t1++;
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
		if(opterr == 0 && noderr == 0 && reserr == 0 && d1err == 0 && staffErr ==0){
			var alternateMail =new Array();
			$(".tt #inrow").each(function(){
				var row = $(this).find("td");
				var value = row.find("#datee").val();
				var hr = row.find("#hr").val();
				var alter = row.find("#alterstaff").val();
				if (alter == '')
				alter = row.find("#alterstaff1").val();
				var cid = row.find("#class1").val();			
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
			var tdate = $("#date1").val();
			temp = $.datepicker.parseDate("dd/mm/yy",tdate);
			tdate = $.datepicker.formatDate("yy-mm-dd",temp);
			var res = $("#res").val();
			var addr = $("#addr").val();
			$.post("qengine.php",{
				op:13,
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
					var StaffContent = " Leave Type : <b> "+ ltype.toUpperCase() +"</b>(Leave Type) <br/>Number of Days :<b>0.5 day(s)</b><br/>From Date:<b> "+fdate+" </b><br/>To date:<b> "+tdate +"</b><br/>Applied date : <b>"+today+"</b>";
					$.post("../testMail.php",{
						content : StaffContent ,
						subject : "Applied Successfully ! Leave CL ",
						toEmail : staffmail,//"dyaneshvarun@gmail.com",//staffmail, //Staff Mail ID
						toName  : $("#name").val()  //Name of the corresponding Email
					},function(data,status){
						//alert(data);
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
							//alert(data);
						});;
						
					}
			
					alert("Leave Requested Successfully");
					$body.removeClass("loading");
					modal.style.display = "none";
					window.location.replace("index.php");
					window.open("table.php");
				}
				if(data == 2){
					var today = new Date();
					var StaffContent = " Leave Type : <b> "+ ltype.toUpperCase() +"</b>(Leave Type) <br/>Number of Days :<b>0.5 day(s)</b><br/>From Date:<b> "+fdate+" </b><br/>To date:<b> "+tdate +"</b><br/>Applied date : <b>"+today+"</b>";
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
						var HODContent = "Leave Applied by <b>"+ $("#name").val()+ " from "+ fdate +" to "+ tdate+ "</b> <br/>Leave ID :  <b>"+recentlid+" </b> <br/>Number of Days :  <b>0.5 day(s)</b><br/>Leave Type :  "+ltype.toUpperCase()+"</b><br/>Kindly review the leave at Website";
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
						toEmail : staffmail,//"dyaneshvarun@gmail.com",//staffmail, //Staff Mail ID
						toName  : $("#name").val()  //Name of the corresponding Email
					},function(data,status){
						//alert(data);
					});;
					
					alert("Leave Requested Successfully");
					$body.removeClass("loading");
					modal.style.display = "none";
					window.location.replace("index.php");
					window.open("table.php");
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
			//alert("Form Not Valid " + opterr + noderr + reserr + d1err+staffErr);
			$body.removeClass("loading");
			modal.style.display = "none";
		}
		},1000);	//Timeout
	});

});
