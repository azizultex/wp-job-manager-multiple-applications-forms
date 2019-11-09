<?php
/**
 * wpjmaf: Custom metabox
 *
 * @package WordPress
 * @subpackage wpjmaf
 * @since 1.0
 */

class CustomMetaBox {

    public function __construct() {
        add_action('add_meta_boxes', array( $this, 'wpjmaf_page_header_metabox' ), 10, 2);
        add_action('save_post', array( $this, 'wpjmaf_page_header_metabox_save' ), 10, 3);

        add_action('admin_enqueue_scripts', array( $this, 'enqueue_assets' ));
    }

    /*
     * wpjmaf Page Header Metabox
     */
    public function wpjmaf_page_header_metabox() {
        add_meta_box(
            'wpjmaf_page_header',
            __( 'Select Application Form', 'wpjmaf' ),
            array($this, 'wpjmaf_select_form' ),
            array('job_listing'),
            'normal',
            'high'
        );
    }

    public function wpjmaf_select_form($post) {
        // We'll use this nonce field later on when saving.
        wp_nonce_field( 'wpjmaf_page_header_meta_box_nonce', 'meta_box_nonce' );

        $form_id =  get_post_meta( $post->ID, 'wpjmaf_form_id', true );

    ?>

	    <div class="wpjmaf_page_header_box">
		    <style>
		    </style>
		    <p class="meta-options wpjmaf_page_header_field hide_show">
	        	<label for="wpjmaf_page_header_title"><?php esc_html_e( 'Gravity forms', 'wpjmaf' ); ?></label>
                <?php 
                if ( !function_exists('get_all_forms_shortcode') ) {
                    echo '<select name="wpjmaf_form_id">';
                    $forms = GFAPI::get_forms();
                    foreach ( $forms as $form) {
                        $formId = $form['fields'][0]->formId;
                        $selected = $formId == $form_id ? 'selected' : '';
                        printf('<option value="%d" %s>%s</option>', $formId, $selected, $form['title']);
                    }
                    echo '</select>';
                }
                ?>
		    </p>
		</div>
    <?php
    }

    public function wpjmaf_page_header_metabox_save( $post_id ) {

        if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'wpjmaf_page_header_meta_box_nonce' ) ) {
            return true;
        }
        if (!current_user_can("edit_post", $post_id)) {
            return $post_id;
        }
        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
            return $post_id;
        }

        //save database
        if (isset($_POST['wpjmaf_form_id'])) {
            $form_id = absint($_POST['wpjmaf_form_id']);
            // var_dump($form_id);
        }
 
    
        update_post_meta($post_id, 'wpjmaf_form_id', $form_id);

        return $post_id;
    }

    public function enqueue_assets() {
    }
}

new CustomMetaBox;