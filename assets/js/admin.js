jQuery( document ).ready( function ( $ ) {
	
	$('.tab-shortcode_builder input').on('change', function(){
		var prefix = '[campusexplorer';
		
		var produced_shortcode = '';
		$('.tab-shortcode_builder .form-table input').each(function(){
			var this_val = $(this).val();
			var this_name = $(this).attr('name').replace('ce_', '');
			if(this_val){
				if ($(this).is(':checkbox')){
					if( $(this).prop('checked')){
						produced_shortcode += ' ' + this_name + '="' + 1 + '"';
					}
				}else{
					produced_shortcode += ' ' + this_name + '="' + htmlEntities(this_val) + '"';
				}
			}
		});
		
		var suffix = ']';

		$('#generated-shortcode code').text(prefix + produced_shortcode + suffix);
	});

	// widget is_lightbox - show/hide button text field
	$('.campusexplorer_widget_is_lightbox_input').each(function() { 
		if ($(this).prop('checked')!=true){ 
			$(this).parent('p').next('.display_lightbox_btn_txt').hide();
		}
	});
	$('.campusexplorer_widget_is_lightbox_input').change(function(){
	    if ($(this).prop('checked')) {
	    	$(this).parent('p').next('.display_lightbox_btn_txt').show();
	    }else{
	    	$(this).parent('p').next('.display_lightbox_btn_txt').hide();
	    }

	});

	function htmlEntities(str) {
		var escaped = str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	    return escaped;
	}

});