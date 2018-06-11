
var division = '<div id="loadingDiv" class="modal1"><div class="modal1-content">\
				<center><img src="ajax-loader.gif"></img><h2>Please wait...</h2></center>\
				</div></div>';
		
$body = $("body");
$body.append(division);
	function addLoadingClass(){
		var modal = document.getElementById("loadingDiv");
		modal.style.display = 'block';
		$("#loadingDiv").addClass("modal1");
		console.log("Added Loading Class");
	}
	function removeLoadingClass(){
		var modal = document.getElementById("loadingDiv");
		modal.style.display = 'none';
		$("#loadingDiv").removeClass("modal1");
		console.log("Removed Loading Class");
	}
	