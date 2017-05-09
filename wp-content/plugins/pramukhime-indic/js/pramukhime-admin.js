
// This file is for Admin option page only
(function($) {
	var $document = $( document );
	
// Execute upon page load
$document.ready( function(){ 
	// Initialize sortable language
	// make language sortable
	$('div.widgets-sortables').sortable({
			placeholder: 'widget-placeholder',
			items: '> .widget',
			handle: '> .widget-top > .pi-language-title',
			cursor: 'move',
			distance: 2,
			containment: '#wpwrap',
			tolerance: 'pointer',
			refreshPositions: true
		}).sortable( 'option', 'connectWith', 'div.widgets-sortables' );
	
	// select all button click
	$("#pramukhime-selectall").on('click', function () {
		$("#sidebar-1 input:checkbox").prop('checked', true);
	});
	// deselect all button click
	$("#pramukhime-deselectall").on('click', function () {
		$("#sidebar-1 input:checkbox").prop('checked', false);
	});
	// set hidden element value based on selected shortcut key
	$("#toggle_shortcut_key").change(function() {
		$('#toggle_shortcut_title').val($(this).find("option:selected").text());
	});
	// disable id textbox if selected radio is not 'all'
	$("#enable_all,#enable_for,#enable_except").change(function() {
		var val = $(this).val();
		$('#enable_id_ui').prop('disabled', (val=='all'));
	});
	// set hidden value based on selected value
	$("#enable_id_ui").change(function() {
		$('#enable_id').val($(this).val());
	});
	
	
	// confirm with user before proceeding with settings reset
	$("#pramukhime-plugin-reset").on('click', function () {
		if(confirm('Are you sure you want to reset settings?'))
		{
			return true;
		}
		return false;
	});
	
} );

})(jQuery);
