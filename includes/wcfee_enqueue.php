<?php

// ---------------------------------------------------------
// Enqueue All Plugin Scripts & Styles
// ---------------------------------------------------------

add_action( "admin_enqueue_scripts", "wcfee_enqueue_scripts");

function wcfee_enqueue_scripts(){
	wp_enqueue_script( "wcfee_app", plugins_url( "/assets/admin/js/app.js", WCFEE_PLUGIN_URL ), array('jquery','select2') );
}

?>