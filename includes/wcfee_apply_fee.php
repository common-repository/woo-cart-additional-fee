<?php

// ---------------------------------------------------------
// Apply Additional Fee on cart
// ---------------------------------------------------------

add_action( 'woocommerce_cart_calculate_fees',  'wcfee_apply_fee' );

function wcfee_apply_fee(){

	global $woocommerce;

    $enabled 				= get_option('wcfee_enable','no');

    $wcfee_label 			= get_option('wcfee_label','Additional Fee : ');
    $wcfee_type 			= get_option('wcfee_type');

    $wcfee_fixed_fee 		= floatval(get_option('wcfee_fixed',0));
    $wcfee_percentage_value = floatval(get_option('wcfee_percentage'));

    $wcfee_enable_minimum   = get_option('wcfee_enable_minimum','no');
    $wcfee_enable_maximum   = get_option('wcfee_enable_maximum','no');

    $wcfee_enable_product_filter  = get_option('wcfee_enable_product_filter','no');

    $wcfee_minimum_amount   = floatval(get_option('wcfee_minimum',0));
    $wcfee_maximum_amount   = floatval(get_option('wcfee_maximum',0));

    $wcfee_product_list     = array_map( 'intval',get_option('wcfee_product_filter')); // convert string values to int

    $cart_total = floatval($woocommerce->cart->cart_contents_total);

    if( $enabled !== 'yes' ) return; // if not enabled do nothing

    switch ($wcfee_type) {

    	case 'fixed':

    		$fee = $wcfee_fixed_fee;
    		break;

    	case 'percentage':

    		$fee = ($wcfee_percentage_value / 100) * $cart_total;
    		break;

    	default:

    		$fee = 0;
    		break;
    }

    if ($wcfee_enable_minimum == 'yes' && $wcfee_enable_maximum !== 'yes') {

    	if ($cart_total >= $wcfee_minimum_amount) {

    		wcfee_product_filter_enabled($wcfee_enable_product_filter,$wcfee_product_list,$wcfee_label,$fee);

      	}

    }

    if ($wcfee_enable_minimum !== 'yes' && $wcfee_enable_maximum == 'yes') {

    	if ($cart_total < $wcfee_maximum_amount) {

    		wcfee_product_filter_enabled($wcfee_enable_product_filter,$wcfee_product_list,$wcfee_label,$fee);

      	}

    }

    if ($wcfee_enable_minimum == 'yes' && $wcfee_enable_maximum == 'yes') {

    	if (($cart_total >= $wcfee_minimum_amount) && ($cart_total < $wcfee_maximum_amount)) {

    		wcfee_product_filter_enabled($wcfee_enable_product_filter,$wcfee_product_list,$wcfee_label,$fee);

      	}

    }

}

function wcfee_product_filter_enabled($enable,$product,$label,$fee){

	global $woocommerce;

	if ($enable == 'yes') {

		foreach($woocommerce->cart->get_cart() as $cart_item ) {

		    $product_id = $cart_item['product_id'];

		    if (in_array($product_id, $product)) {
		    	$woocommerce->cart->add_fee($label,$fee);
		    }
		}
	}else{
		$woocommerce->cart->add_fee($label,$fee);
	}
}

?>