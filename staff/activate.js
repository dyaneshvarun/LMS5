var serr = 1,eerr = 1,perr = 1,cperr = 1;
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
$(document).ready(function(){
	$("#fsub").submit(function(e){
		e.preventDefault();
		alert("Form Submit Pressed");
		var sid = $("#sid").val();
		if(sid == ''){
			serr = 1;
			dispErr('#sid',' StaffID Should Not be Empty ');
		}else{
			serr = 0;
			clearErr('#sid');
		};
		var email = $("#email").val();
		if(email == ''){
			eerr = 1;
			dispErr('#email',' Email Address Should Not be Empty ');
		}else{
			eerr = 0;clearErr('#email');
		}
		var pass = $("#pass").val();
		if(pass == ''){
			perr = 1;
			dispErr('#pass'," Password Must not be Empty ");
		}else{
			perr = 0;clearErr("#pass");
		}
		var cpass = $("#cpass").val();
		if(cpass != pass){
			cperr = 1;
			dispErr('#cpass'," Password Not Matching ");
		}else{
			cperr = 0;clearErr("#cpass");
		}
		if(serr == 0 && eerr == 0 && perr == 0 && cperr == 0){
			alert("Form Valid");
			$.post("activate.php",
			{
				op:1,
				si:sid,
				em:email,
				pa:pass
			},function(data,status){
				alert(data);
				switch(data){
					case '1':
						alert("Staff Not Exist or Already Activated");
						break;
					case '2':	
						alert("Already Activated");
						break;
					case '99':
						alert("Form Inputs Invalid");
						break;
					case '0':
						alert("Staff Activated Successfully");
						break;
					default:
						alert("Form Not Valid");
						break;
				}
			});
		}
		else{
			alert("Form Not Valid");
		}
	});
});
