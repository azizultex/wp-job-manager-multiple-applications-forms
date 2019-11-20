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

add_filter( 'job_manager_locate_template', 
    function( $template, $template_name, $template_path )
    {
        global $post;
        $form_id =  get_post_meta( $post->ID, 'wpjmaf_form_id', true );

        if( 'application-form.php' === $template_name && class_exists('GFAPI') && GFAPI::get_form( $form_id ) )
        {
           return dirname(__FILE__) . '/inc/' . $template_name;
        }
        return $template;
    }
, 10, 3 );