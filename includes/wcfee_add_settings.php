<?php

	/**
	* Hook all required actions & filters.
	**/

	add_filter( 'woocommerce_settings_tabs_array', 'wcfee_add_settings_tab', 50 );
	add_action( 'woocommerce_settings_tabs_wcfee_settings', 'wcfee_settings_tab' );
	add_action( 'woocommerce_update_options_wcfee_settings', 'wcfee_update_settings' );


	/**
	*  Add a new settings tab to the WooCommerce settings tabs array.
	*  @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Woocommerce Cart Additional Fee tab.
	*  @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Woocommerce Cart Additional Fee tab.
	*/
	function wcfee_add_settings_tab($settings_tabs){
		$settings_tabs['wcfee_settings'] = __( 'Woo Cart Additional Fee', 'woo_cfee' );
	    return $settings_tabs;
	}

	/**
	* Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
	*
	* @uses woocommerce_admin_fields()
	* @uses wcfee_get_settings()
	*/
	function wcfee_settings_tab() {
		woocommerce_admin_fields( wcfee_get_settings() );
	}

	/**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses wcfee_get_settings()
     */
    function wcfee_update_settings() {
        woocommerce_update_options( wcfee_get_settings() );
    }

    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    function wcfee_get_settings() {

    	$settings = array(
            'section_title' => array(
                'name'     => __( 'Woocommerce Cart Additional Fee Settings Panel', 'wcfee' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wcfee_tab_section_title',
            ),
            'enable' => array(
                'name'     => __( 'Enable ', 'wcfee' ),
                'type' => 'checkbox',
                'desc'     => __( 'Enable / Disable Additional Fee Options', 'wcfee' ),
                'id'       => 'wcfee_enable',
            ),
            'label' => array(
                'name'     => __( 'Additional Fee Label', 'wcfee' ),
                'type' => 'text',
                'placeholder'   => __( 'Enter Additional Fee Label text', 'wcfee' ),
                'id'       => 'wcfee_label',
            ),
            'charges_type' => array(
                'name'     => __( 'Fee Apply Type', 'wcfee' ),
                'type' => 'select',
                'id'       => 'wcfee_type',
                'options'  => array(

                		'none' => __('Choose Fee Type','wcfee'),
                		'fixed' => __('Fixed Fee','wcfee'),
                		'percentage' => __('Percentage (%) Based Fee','wcfee')
                )
            ),
            'charges_type_fixed' => array(
                'name'     => __( 'Fixed Fee Amount', 'wcfee' ),
                'type' => 'text',
                'placeholder'     => __( 'Set Fixed Fee Amount', 'wcfee' ),
                'id'       => 'wcfee_fixed',
            ),
            'charges_type_percentage' => array(
                'name'     => __( 'Percentage Fee Amount', 'wcfee' ),
                'type' => 'text',
                'placeholder'     => __( 'Set Percentage Value', 'wcfee' ),
                'id'       => 'wcfee_percentage',
            ),
            'enable_minimum' => array(
                'name'     => __( '', 'wcfee' ),
                'type' => 'checkbox',
                'desc'     => __( 'Enable Minimum Cart Amount Check', 'wcfee' ),
                'id'       => 'wcfee_enable_minimum',
            ),
            'minimum' => array(
                'name'     => __( 'Minimum Cart Amount', 'wcfee' ),
                'type' => 'text',
                'placeholder'     => __( 'Set Minimum total cart amount to apply Additional Fee', 'wcfee' ),
                'id'       => 'wcfee_minimum',
            ),
            'enable_maximum' => array(
                'name'     => __( '', 'wcfee' ),
                'type' => 'checkbox',
                'desc'     => __( 'Enable Maximum Cart Amount Check', 'wcfee' ),
                'id'       => 'wcfee_enable_maximum',
            ),
            'maximum' => array(
                'name'     => __( 'Maximum Cart Amount', 'wcfee' ),
                'type' => 'text',
                'placeholder'     => __( 'Set Maximum total cart amount to apply Additional Fee', 'wcfee' ),
                'id'       => 'wcfee_maximum',
            ),
            'enable_specific_product' => array(
                'name'     => __( '', 'wcfee' ),
                'type' => 'checkbox',
                'desc'     => __( 'Enable Fee For Specific Product', 'wcfee' ),
                'id'       => 'wcfee_enable_product_filter',
            ),
            'enable_for_specific_product' => array(
                'name'     => __( 'Apply Fee For Specific Product', 'wcfee' ),
                'type' => 'multiselect',
                'placeholder'   => __( 'Select Product to apply Additional Fee', 'wcfee' ),
                'id'       => 'wcfee_product_filter',
                'options'  =>
                	wcfee_create_product_list_array()
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wcfee_tab_section_end'
            )
          );
    	return apply_filters( 'wc_settings_wcfee_settings', $settings );
    }


?>