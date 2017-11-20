$(document).ready(function(){
	$("#fsub").submit(function(e){
		e.preventDefault();
		$('.leavestat').each(function(){
			if($(this).val() != 'none'){
				var lid = $(this).attr('id');
				var stat = $(this).val();
				if(stat == 'ACCEPT'){
					var numstat = 1;
				}else var numstat = 2;
				/*if(numstat==1){
					$.post("qengine.php",{
						op:"12",
						lid:lid
						
					},function(data,status){
						//alert(data);

					});
				}
				else if(numstat==2){
					$.post("qengine.php",{
						op:"13",
						lid:lid
						
					},function(data,status){
						//alert(data);
						
					});
				}
				*/
				$.post("qengine.php",{
					op:"14",
					lid:lid,
					lstat:numstat
				},function(data,status){
					//alert(data);
					window.location.replace("compensation.php");
				});
				
			}
		});
	});
});
