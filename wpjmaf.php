<?php
/**
 * @package wpjmaf
 * @version 1.0.0
 */
/*
Plugin Name: WP Job Manager Application From
Plugin URI: https://keendevs.com
Description: A job manager application form extension that enable selecting fields for job specific
Author: Azizul Haque
Version: 1.0.0
Author URI: https://keendevs.com
*/

include( 'inc/form-select-meta-box.php' );

add_filter('job_application_form_fields', function($option){
    return;
});

function load_wpjmaf_form(){
    global $post;
    $form_id =  get_post_meta( $post->ID, 'wpjmaf_form_id', true );

    $forms = GFAPI::get_forms();
    foreach ( $forms as $form) {
        $formId = $form['fields'][0]->formId;
        if($formId == $form_id){
            echo do_shortcode("[gravityform id={$formId} title=false description=false ajax=true]");
        }
    }
}
add_action('job_application_form_fields_start', 'load_wpjmaf_form');

// remove_action('job_manager_application_details_email', array('WP_Job_Manager_Applications_Apply', 'application_form'), 20 );

function wpjmaf_plugins_load(){
    remove_action('job_manager_application_details_email', array('WP_Job_Manager_Applications_Apply', 'application_form'), 20 );
}

// add_action('plugins_loaded', 'wpjmaf_plugins_load', 22);


add_filter( 'job_manager_locate_template', 
    function( $template, $template_name, $template_path )
    {

        if( 'application-form.php' === $template_name )
        {
            
        }
        return $template;
    }
, 10, 3 );