<?php 

global $post;
$form_id =  get_post_meta( $post->ID, 'wpjmaf_form_id', true );

$forms = GFAPI::get_forms();
foreach ( $forms as $form) {
    $formId = $form['fields'][0]->formId;
    if($formId == $form_id){
        echo do_shortcode("[gravityform id={$formId} title=false description=false ajax=true]");
    }
}