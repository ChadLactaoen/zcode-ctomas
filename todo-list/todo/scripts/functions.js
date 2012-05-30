$(document).ready(function(){
	$('.form').hide();
			
	// Removes "Add Task Button" if a list isn't loaded
	if($('#nolisterror').length > 0) {
		$('#add-button').css('display', 'none');
		$('#logout-button').css('display', 'none');
	}
	
	// Toggle switches for the buttons in the sidebar
	$('#load-button').toggle(
		function(){
			$('#load-button + .form').show("slow");
		}, 
		function(){
			$('#load-button + .form').hide("slow");
		}
	);
	
	$('#new-button').toggle(
		function(){
			$('#new-button + .form').show("slow");
		}, 
		function(){
			$('#new-button + .form').hide("slow");
		}
	);
	
	$('#add-button').toggle(
		function(){
			$('#add-button + .form').show("slow");
		}, 
		function(){
			$('#add-button + .form').hide("slow");
		}
	);
});