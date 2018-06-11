$(document).ready(function(){
	$("#fsub").submit(function(e){
		e.preventDefault();
		var numstats = new Array();
		var leaves = new Array();
		$('.leavestat').each(function(){
			if($(this).val() != 'none'){
				var lid = $(this).attr('id');
				var stat = $(this).val();
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
					//alert(data);
					
				});
				
			}	
		});
		for(var j =0;j<numstats.length;j++)
		{
			if(numstats[j]==1){
				$.post("qengine.php",{
					op:"12",
					lid:lid
					
				},function(data,status){
					//alert(data);
				});
			}
			else if(numstats[j]==2){
				$.post("qengine.php",{
					op:"13",
					lid:lid
				},function(data,status){
					//alert(data);
				});
			}
		}
	});
	$("#caarb").on('click',function(){
		$('.leaves').each(function(){
			$(this).find("#r").find(".leavestat").removeAttr('checked');
			$(this).find("#a").find(".leavestat").prop('checked','true');
		});
	});
	$("#carrb").on('click',function(){
		$('.leaves').each(function(){
			$(this).find("#a").find(".leavestat").removeAttr('checked');
			$(this).find("#r").find(".leavestat").prop('checked','true');
		});
	});
});
