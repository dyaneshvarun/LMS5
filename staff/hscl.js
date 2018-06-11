var opterr = 0,noderr = 1,d1err =1, d2err =1, reserr=1;
var allstaffID= new Array(),allstaffName = new Array();
var apperr = "<span class='glyphicon glyphicon-remove form-control-feedback'></span><span class='help-block'>";
var pherr=0;
function dispErr(tag,msg){
	$(tag).closest("div").addClass("has-error").addClass("has-feedback");
	$(tag).closest("div").find('span').remove();
	$(tag).closest("div").append(apperr + msg + "</span>");
}
function clearErr(tag){
	$(tag).closest("div").removeClass("has-error").removeClass("has-feedback");
	$(tag).closest("div").find('span').remove();
}
$body = $("body");
//Date Picker for Postponed Date
	$(document).on('focusin click','[id^=pd]',function(){
		$(this).datepicker(
			{dateFormat: 'yy-mm-dd',  changeMonth: true, changeYear: true, yearRange: '2016:2019',minDate:new Date}
		);
		$(this).parent().parent().find("td").find("select[id^=hr1] option").remove();
		$(this).parent().parent().find("td").find("select[id^=hr1]").hide();
	});
$(document).ready(function(){
	// Get the modal
	var modal = document.getElementById('modal');
	var sta_id = $("#sid").val();
	$("#date1,#date2").focusin(function(){
		$(this).datepicker(
			{dateFormat: 'dd/mm/yy',  changeMonth: true, changeYear: true, yearRange: '2016:2017'}
		);
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
	$("#nod").change(function(){
		var nod = $("#nod").val();
		var balance = $("#bal").val();
		$("#date1,#date2").val("");
		if(nod >= 1 && nod<=balance ){
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
		$('#res').prop('disabled',false);
		var session=$("#session").val();
		$('#addr').prop('disabled',false);
		var date1 = new Date($('#date1').datepicker('getDate'));
		var vacationChecked = $("#vacation").prop("checked");
		//changed code
		var fromdate = $('#date1').datepicker('getDate');
		var today = new Date();
		
		if(today>fromdate)
			alert("You are selecting the date that is prior to Todays'Date");
		//changed code
		
		//var date2 = new Date($('#date2').datepicker('getDate'));
		$("#altertitle1").empty();
		var temp = date1;
		var count=1;
		var t1 = 0;
		while(t1 < count ){
			
			var day = temp.getDay();
			pherr = 0;
			var checkPHDate = $.datepicker.formatDate("yy-mm-dd",temp);
			$.ajax({
					type: 'POST',
					url: 'checkPH.php',
					data: {date1:checkPHDate},
					async: false,
					success: function(result1){
						
						pherr=result1;
					}});
				
			if(day!=0 && day!=6  && pherr==0 ){
				
				var showDate = $.datepicker.formatDate("dd/mm/yy",temp);
				var dbDate = $.datepicker.formatDate("yy--mm-dd",temp);
				//Postponement Change
				var insr = "<div class='form-group' class='altrem' id='dutyalter11' style='width:1000px;'><div class='col-lg-12'><table class='table table-bordered tt' id='tableD" + t1 + "' > <tr> <th> Date </th> <th> Class  </th> <th> A/P </th><th> Hour </th> <th> Alternatives</th><th>Others</th><th>Postponed Date</th><th>Postponed Hour</th></tr> </table> </div> </div>";
				$("#altertitle1").append(insr);
				t1++;
			}
			if(t1==count){
				var d2date = $.datepicker.formatDate("dd/mm/yy",temp);
				//alert(d2date);
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
			pherr = 0;
			var checkPHDate = $.datepicker.formatDate("yy-mm-dd",temp);
			$.ajax({
					type: 'POST',
					url: 'checkPH.php',
					data: {date1:checkPHDate},
					async: false,
					success: function(result1){
						//pherror = result1;
						pherr=result1;
					}});
				
			if(day!=0 && day!=6  && pherr==0 ){
			
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
							//Postponement Replacement
							t2 = t1;
							var tablen = "#tableD" + t2;
							var ins = "<tr id='inrow'><td class='col-xs-2'>";
							ins += "<input class='form-control' type='text' id='datee' value='"+ dbDate + "' disabled></input></td>";
							ins += "<td class='col-sm-2'><input type='text' class='form-control' id='class1' value='" + obj.CLASS_ID + "' disabled ></td>";
							ins += "<td class='col-sm-1'><input type='text' class='form-control' id='hr' value='" + obj.HOUR + "'  disabled></td>";
							ins += "<td><input type='radio' name='choose"+t2+i+"' id='ap' value='A' checked>Alternate</input></td>";//changed code
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
							ins += "</td><td></td><td></td></tr>";
							
							//postRow
							ins += "<tr id='postrow' ><td></td><td></td>";
							ins += "<td></td>";
							ins += "<td><input type='radio' name='choose"+t2+i+"' id='ap' value='P'>Postpone</input></td>";
							ins += "<td><p hidden id='psn' >"+$("#name").val()+"</p></td><td></td>";
							ins += "<td><input class='form-control' type='text' id='pd"+t2+i+"' disabled ></input><input type='button' class='btn btn-success' value='Check Slot' id='cs"+t2+i+"'></input></td>";
							ins += "<td class='col-sm-1'><select class='form-control' id='hr1"+t2+i+"' value='" + obj.HOUR + "' disabled ></td></tr>"
							$(tablen).append(ins);
							countAlter++;
							$("#psn").hide();
							$("#pd"+t2+i+"").hide();
							$("#hr1"+t2+i+"").hide();
							$("#cs"+t2+i+"").hide();
						});
						//Postponement Replacement});	
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
	//Alteration or Postponement Selection
	$("#altertitle1").on('change','input[type=radio][name^=choose]',function()
	{
		var checkedap = $(this).val();
		if(checkedap=='P')
		{	var row = $(this).parent().parent().find("td");
			var datep = row.find("input[id^=pd]");
			var csp = row.find("input[id^=cs]");
			csp.show();
			$(datep).prop('disabled',false);$(datep).show();
			row.find("#psn").show();
			var rowbefore = $(this).parent().parent().prev();
			rowbefore.find("#alterstaff").val('');
			rowbefore.find("#alterstaff1").val('');
			rowbefore.find("#alterstaff").hide();
			rowbefore.find("#alterstaff1").hide();
			//rowbefore.find("#hr").hide();
		}else{
			var rownext = $(this).parent().parent().next().find("td");
			var datep = rownext.find("input[id^=pd]");
			$(datep).prop('disabled',true);
			$(datep).hide();
			rownext.find("#psn").hide();
			rownext.find("input[id^=cs]").hide();
			rownext.find("select[id^=hr1]").hide();
			rownext.find("select[id^=hr1] option").remove();
			var row = $(this).parent().parent().find("td");
			var as = row.find("#alterstaff");
			var as1 = row.find("#alterstaff1");
			as.prop('disabled',false);
			as1.prop('disabled',false);
			as.show();
			as1.show();
			//row.find("#hr").show();
		}
	});
	//Check Slot Function
	$("#altertitle1").on('click','input[id^=cs]',function(){
		var row = $(this).parent().parent().find("td");
		var pd = row.find("input[id^=pd]").val();
		var clas = $(this).parent().parent().prev().find("td").find("#class1").val();
		var opt = "";
		var avail = [1,2,3,4,5,6,7,8];
		$.post("qengine.php",{
			op:23,
			clasVal: clas,
			posd: pd
		},function(data,status){
			var parsed = $.parseJSON(data);
			$.each(parsed,function(i,obj){
				if(avail.includes(parseInt(obj.HOUR))) avail.splice(avail.indexOf(parseInt(obj.HOUR)),1);
			})
			if(avail.length == 0)
			{				
				row.find("select[id^=hr1]").hide();
				alert("No free Slot found. Please change the postponement date.");
			}
			else{
			for(var i = 0;i < avail.length;i++)opt+="<option value = "+avail[i]+" >"+avail[i]+"</option>";
			var sel = row.find("select[id^=hr1]");
			var id = "#"+ sel.attr('id');
			$(id+" option"+"").remove();
			$(id).append(opt);
			$(id).show();
			$(id).prop('disabled',false);}
		});
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
	var fileNameIs;
	$('#uploadButton').on('click', function() {
		var file_data = $('#upload').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);
		//alert(form_data);                             
		$.ajax({
					url: 'upload.php', // point to server-side PHP script 
					//dataType: 'text',  // what to expect back from the PHP script, if anything
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,                         
					type: 'post',
					success: function(response){
						//alert(php_script_response); // display response from the PHP script, if any
						if(response!="ERRUPLOAD")
						{
							fileNameIs = response;
							alert(fileNameIs);
							alert("Document Uploaded Successfully.");
						}
					}
		 });
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
				//Postponement Change
				var row123 = $(this).find("td");
				var apopt = row123.find("input[type=radio][name^=choose]:checked").val();
				if(apopt=='A'){
				var alter123 = row123.find("#alterstaff").val();
				if (alter123 == '')
					alter123 = row123.find("#alterstaff1").val();	
				if (alter123 == '') staffErr = 1;}
				//Postponement Change
			});
		if(opterr == 0 && noderr == 0 && reserr == 0 && d1err == 0 && staffErr==0){
			var alterArray = new Array();
			var alternateMail =new Array();
			$(".tt #inrow").each(function(){
				//Postponement Change
				var row = $(this).find("td");
				var value = row.find("#datee").val();
				var cid = row.find("#class1").val();
				alert(row.find("input[type=radio][name^=choose]:checked").val());
				if(row.find("input[type=radio][name^=choose]:checked").val()=='A'){
					var hr = row.find("#hr").val();
					var alter = row.find("#alterstaff").val();
					if (alter == '')
						alter = row.find("#alterstaff1").val();	
					var eachAlter = {year:value, hour:hr, alterstaff:alter,class:cid,pdate:'X',phr:'X'};
					alternateMail.push(alter);
				}
				else//Value is P
				{
					var row1 = $(this).next();
					var pd = row1.find("input[id^=pd]").val();
					var hr = $(this).find("#hr").val();
					var phr = row1.find("select[id^=hr1]").val();
					var alter = $("#sid").val();
					alert(pd);
					var eachAlter = {year:value, hour:hr, alterstaff:alter, class:cid,pdate:pd,phr1:phr};
					alternateMail.push(alter);
				}
				alterArray.push(eachAlter);
				//Postponement Change Ends
			});			
			//alert(JSON.stringify(alterArray));
			
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
			
			var fdate = $("#date1").val();
			var temp = $.datepicker.parseDate("dd/mm/yy",fdate);
			fdate = $.datepicker.formatDate("yy-mm-dd",temp);
			var tdate = $("#date2").val();
			temp = $.datepicker.parseDate("dd/mm/yy",tdate);
			tdate = $.datepicker.formatDate("yy-mm-dd",temp);
			var res = $("#res").val();
			var addr = $("#addr").val();
			var nod = $("#nod").val();
			$.post("qengine.php",{
				op:17,
				alterData:alterArray,
				lt:'SCL',
				fd:fdate,
				td:tdate,
				re:res,
				ad:addr,
				nod:nod,
				fileName:fileNameIs
			},function(data,status){
				alert(data);
				if(data == 1){
					var today = new Date();
					var StaffContent = " Leave Type : <b> "+ "SCL" +"</b>(Leave Type) <br/>Number of Days :<b>0.5 day(s)</b><br/>From Date:<b> "+fdate+" </b><br/>To date:<b> "+tdate +"</b><br/>Applied date : <b>"+today+"</b>";
					$.post("../testMail.php",{
						content : StaffContent ,
						subject : "Applied Successfully ! Leave SCL ",
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
						});;//*/
					}
					alert("Leave Requested Successfully");
					$body.removeClass("loading");
					modal.style.display = "none";
					window.location.replace("index.php");
					window.open("table.php",'_blank');
				}
				if(data == 2){
					var ltype = "SCL";
					var today = new Date();
					var StaffContent = " Leave Type : <b> "+ "SCL" +"</b>(Leave Type) <br/>Number of Days :<b>0.5 day(s)</b><br/>From Date:<b> "+fdate+" </b><br/>To date:<b> "+tdate +"</b><br/>Applied date : <b>"+today+"</b>";
					//Get recent Leave ID
					var recentlid;
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
						var HODContent = "Leave Applied by <b>"+ $("#name").val()+ " from "+ fdate +" to "+ tdate+ "</b> <br/>Leave ID :  <b>"+recentlid+" </b> <br/>Number of Days :  <b>0.5</b><br/>Leave Type :  SCL</b><br/>Kindly review the leave at Website";
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
						subject : "Applied Successfully ! Leave " + ltype.toUpperCase() ,
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
