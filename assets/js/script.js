$(document).ready(function(){
	
});
function incorrect(){
	var duration = 80;
	var offset = 30;
	// var mLeft = $('#logbox').css('marginLeft');
	$('#logbox').css('position','relative');
	$('#logbox').animate({left:('-='+ offset)}, duration,function(){
	   $(this).animate({left:('+=' + offset*2)}, duration, function(){
		  $(this).animate({left:('-=' + offset*2)}, duration, function(){
			   $(this).animate({left:('+='+ offset*2)}, duration, function(){
				   $(this).animate({left:('-='+ offset*2)}, duration, function(){
					   $(this).animate({left:('+='+ offset)}, duration);
				   });
			   });
		  });
	   });
	});
	// alert();
}