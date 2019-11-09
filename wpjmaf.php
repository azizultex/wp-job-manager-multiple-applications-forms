<?php
/**
 * @package wpjmaf
 * @version 1.0.0
 */
/*
Plugin Name: WP Job Manager Multiple Application From
Plugin URI: https://keendevs.com
Description: A job manager application form extension that enable selecting fields for job specific
Author: Azizul Haque
Version: 1.0.0
Author URI: https://keendevs.com
*/

include( 'inc/form-select-meta-box.php' );


function wpjmaf_plugins_load(){

}

// add_action('plugins_loaded', 'wpjmaf_plugins_load', 22);


add_filter( 'job_manager_locate_template', 
    function( $template, $template_name, $template_path )
    {
        if( 'application-form.php' === $template_name )
        {
           return dirname(__FILE__) . '/inc/' . $template_name;
        }
        return $template;
    }
, 10, 3 );