var emerr = 1, perr = 1;
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
	$("#email").focusout(function(){
		var email = $("#email").val();
		if(email == ''){
			emerr = 1;
			dispErr("#email","Email Address Should not be Empty");
		}else{
			emerr = 0;
			clearErr("#email");
		}
	});
	$("#pass").focusout(function(){
		var pass = $("#pass").val();
		if(pass == ''){
			perr = 1;
			dispErr("#pass","Password Empty");
		}else{
			perr = 0;
			clearErr("#pass");
		}
	});
	$("#fsub").submit(function(e){
		e.preventDefault();
		if(emerr == 0 && perr == 0){
			var email = $("#email").val();
			var pass = $("#pass").val();
			$.post("login.php",
			{
				op:1,
				em:email,
				pa:pass
			},function(data,status){
				alert(data);
				if(data > 0){
					alert("Login Success");
					window.location.replace("index.php");
				}
				else if( data <= 0){
					alert("Login Failed: Invalid Credentials");
				}
				else{
					alert("Login Failed: Check Network");
				}
			});
		}
		else{
			alert("Login Failed. Credentials Empty");
		}
	});
});
