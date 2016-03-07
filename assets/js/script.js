$(document).ready(function(){
	$('#upload_img_btn').on('click', function(e){
		// e.preventDefault();
		$('#upload_files2').trigger('click');  
		// return false;
	});
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

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			$('#profile_img').attr('src', e.target.result);
		}
		
		reader.readAsDataURL(input.files[0]);
	}
}