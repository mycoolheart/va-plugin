<?php
function va_acf_setting_page() {
	if( function_exists('acf_add_options_page') ) {
	    
	    acf_add_options_sub_page(array(
	        'page_title'    => 'Settings VA Plugin',
	        'menu_title'    => 'VA Plugin',
	        'parent_slug'   => 'va-plugin-settings',
	    ));
	}
}
add_action('acf/init', 'va_acf_setting_page');

add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Paste ACF Fields
} );